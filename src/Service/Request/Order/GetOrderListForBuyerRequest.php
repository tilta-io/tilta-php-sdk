<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\Model\Request\Order\GetOrderListForBuyerRequestModel;
use Tilta\Sdk\Model\Response\Order\GetOrderListForBuyerResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetOrderListForBuyerRequestModel, GetOrderListForBuyerResponseModel>
 */
class GetOrderListForBuyerRequest extends AbstractRequest
{
    protected static bool $allowEmptyResponse = true;

    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/orders';
    }

    protected function processSuccess($requestModel, array $responseData): GetOrderListForBuyerResponseModel
    {
        return (new GetOrderListForBuyerResponseModel())->fromArray($responseData);
    }
}
