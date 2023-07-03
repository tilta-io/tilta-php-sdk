<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\Model\Request\Order\OrderListRequestModel;
use Tilta\Sdk\Model\Response\Order\OrderListResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<OrderListRequestModel, OrderListResponseModel>
 */
class GetOrderListRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders';
    }

    protected function processSuccess($requestModel, array $responseData): OrderListResponseModel
    {
        return new OrderListResponseModel($responseData);
    }
}
