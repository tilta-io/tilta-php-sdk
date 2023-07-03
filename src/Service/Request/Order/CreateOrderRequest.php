<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Exception;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateOrderRequestModel, Order>
 */
class CreateOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders';
    }

    protected function processSuccess($requestModel, array $responseData): AbstractModel
    {
        return (new Order([], true))->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
    }
}
