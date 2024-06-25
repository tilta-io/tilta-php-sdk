<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order\CustomData;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Order\CustomDataAttribute;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CustomDataAttribute, CustomDataAttribute>
 */
class CreateCustomDataAttributeRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/custom_data';
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CustomDataAttribute::class;
    }

    protected function processSuccess($requestModel, array $responseData): CustomDataAttribute
    {
        return (new CustomDataAttribute())->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }
}
