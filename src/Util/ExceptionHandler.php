<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use Tilta\Sdk\Enum\OrderStatusEnum;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\Facility\FacilityExceededException;
use Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\InvoiceNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException;
use Tilta\Sdk\Exception\GatewayException\Order\OrderIsCanceledException;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\HasInvoiceIdFieldInterface;
use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\HasOrderIdFieldInterface;

class ExceptionHandler
{
    public static function mapException(GatewayException $exception, AbstractModel $requestModel): ?GatewayException
    {
        if ($requestModel instanceof HasBuyerFieldInterface) {
            if ($exception->getTiltaCode() === 'NO_ACTIVE_FACILITY_FOUND') {
                return new NoActiveFacilityFoundException($requestModel->getBuyerExternalId(), ...self::getDefaultArgumentsForException($exception));
            } elseif ($exception->getTiltaCode() === 'FACILITY_EXCEEDED_AVAILABLE_AMOUNT') {
                return new FacilityExceededException($requestModel->getBuyerExternalId(), ...self::getDefaultArgumentsForException($exception));
            }

            if (self::isEntityNotFoundException('Buyer', $exception->getMessage())) {
                return new BuyerNotFoundException($requestModel->getBuyerExternalId(), ...self::getDefaultArgumentsForException($exception));
            }
        }

        if ($requestModel instanceof HasMerchantFieldInterface && self::isEntityNotFoundException('Merchant', $exception->getMessage())) {
            return new MerchantNotFoundException($requestModel->getMerchantExternalId(), ...self::getDefaultArgumentsForException($exception));
        }

        if (preg_match('/No Merchants? with external_id \[([^\]]+)\] found\.?/', $exception->getMessage(), $matches)) {
            return new MerchantNotFoundException($matches[1], ...self::getDefaultArgumentsForException($exception));
        }

        if ($requestModel instanceof HasOrderIdFieldInterface) {
            if (self::isEntityNotFoundException('Order', $exception->getMessage())) {
                return new OrderNotFoundException($requestModel->getOrderExternalId());
            }

            if ($exception->getMessage() === sprintf('The order is %s and cannot be updated.', OrderStatusEnum::CANCELED) ||  // CANCELLED
                $exception->getMessage() === sprintf('The order is %s and cannot be updated.', 'CANCELED')
            ) {
                return new OrderIsCanceledException(...self::getDefaultArgumentsForException($exception));
            }
        }

        if ($requestModel instanceof HasInvoiceIdFieldInterface && self::isEntityNotFoundException('Invoice', $exception->getMessage())) {
            return new InvoiceNotFoundException($requestModel->getInvoiceExternalId(), ...self::getDefaultArgumentsForException($exception));
        }

        return null;
    }

    private static function isEntityNotFoundException(string $entityName, string $message): bool
    {
        return preg_match('/No ' . $entityName . ' found\.?/', $message) ||
            preg_match('/' . $entityName . ' not found\.?/', $message);
    }

    private static function getDefaultArgumentsForException(GatewayException $exception): array
    {
        return [$exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData()];
    }
}
