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
use Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\Order\CreateOrderCheckoutSessionRequestModel;
use Tilta\Sdk\Model\Response\SessionResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateOrderCheckoutSessionRequestModel, SessionResponseModel>
 */
class CreateOrderCheckoutSessionRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getOrderExternalId() . '/sessions/checkout';
    }

    protected function processSuccess($requestModel, array $responseData): SessionResponseModel
    {
        return new SessionResponseModel($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
        if ($exception instanceof NotFoundException) {
            throw new OrderNotFoundException($requestModel->getOrderExternalId(), $exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
        }
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CreateOrderCheckoutSessionRequestModel::class;
    }
}
