<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\GetOrderDetailsRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetOrderDetailsRequestModel, Order>
 */
class GetOrderDetailsRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getOrderExternalId();
    }

    protected function processSuccess($requestModel, array $responseData): Order
    {
        return (new Order())->fromArray($responseData);
    }
}
