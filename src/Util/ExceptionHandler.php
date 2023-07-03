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
use Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException;
use Tilta\Sdk\Exception\GatewayException\Order\OrderIsCanceledException;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
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

            if ($exception->getMessage() === 'No Buyer found') {
                return new BuyerNotFoundException($requestModel->getBuyerExternalId(), ...self::getDefaultArgumentsForException($exception));
            }
        }

        if ($requestModel instanceof HasMerchantFieldInterface && $exception->getMessage() === 'No Merchant found') {
            return new MerchantNotFoundException($requestModel->getMerchantExternalId(), ...self::getDefaultArgumentsForException($exception));
        }

        if ($requestModel instanceof HasOrderIdFieldInterface) {
            if ($exception->getMessage() === 'No Order found') {
                return new OrderNotFoundException($requestModel->getOrderExternalId());
            }

            if ($exception->getMessage() === sprintf('The order is %s and cannot be updated.', OrderStatusEnum::CANCELED) ||  // CANCELLED
                $exception->getMessage() === sprintf('The order is %s and cannot be updated.', 'CANCELED')
            ) {
                return new OrderIsCanceledException(...self::getDefaultArgumentsForException($exception));
            }
        }

        return null;
    }

    private static function getDefaultArgumentsForException(GatewayException $exception): array
    {
        return [$exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData()];
    }
}
