<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\CreateOrderDraftRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateOrderDraftRequestModel, Order>
 */
class CreateOrderDraftRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/draft';
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CreateOrderDraftRequestModel::class;
    }

    protected function processSuccess($requestModel, array $responseData): Order
    {
        return (new Order())->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }
}
