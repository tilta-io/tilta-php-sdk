<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\Model\Request\Order\GetOrderListRequestModel;
use Tilta\Sdk\Model\Response\Order\GetOrderListResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetOrderListRequestModel, GetOrderListResponseModel>
 */
class GetOrderListRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders';
    }

    protected function processSuccess($requestModel, array $responseData): GetOrderListResponseModel
    {
        return new GetOrderListResponseModel($responseData);
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetOrderListRequestModel::class;
    }
}
