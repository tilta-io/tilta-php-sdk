<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Exception;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\CreateDraftOrderRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateDraftOrderRequestModel, Order>
 */
class CreateDraftOrderRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/draft';
    }

    protected function processSuccess($requestModel, array $responseData): Order
    {
        return (new Order([], true))->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
        if ($exception instanceof NotFoundException) {
            throw new BuyerNotFoundException($requestModel->getBuyerExternalId(), $exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
        }
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CreateDraftOrderRequestModel::class;
    }
}
