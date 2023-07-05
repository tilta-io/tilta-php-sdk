<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\CancelOrderRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CancelOrderRequestModel, Order>
 */
class CancelOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getOrderExternalId() . '/cancel';
    }

    protected function processSuccess($requestModel, array $responseData): Order
    {
        return (new Order())->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CancelOrderRequestModel::class;
    }
}
