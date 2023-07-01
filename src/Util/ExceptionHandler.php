<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\HasMerchantFieldInterface;

class ExceptionHandler
{
    public static function mapException(GatewayException $exception, AbstractModel $requestModel): ?GatewayException
    {
        if ($requestModel instanceof HasBuyerFieldInterface) {
            if ($exception->getTiltaCode() === 'NO_ACTIVE_FACILITY_FOUND') {
                return new NoActiveFacilityFoundException($requestModel->getBuyerExternalId(), $exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
            }

            if ($exception->getMessage() === 'No Buyer found') {
                return new BuyerNotFoundException($requestModel->getBuyerExternalId(), ...self::getDefaultArgumentsForException($exception));
            }
        }

        if ($requestModel instanceof HasMerchantFieldInterface && $exception->getMessage() === 'No Merchant found') {
            return new MerchantNotFoundException($requestModel->getMerchantExternalId(), ...self::getDefaultArgumentsForException($exception));
        }

        return null;
    }

    private static function getDefaultArgumentsForException(GatewayException $exception): array
    {
        return [$exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData()];
    }
}
