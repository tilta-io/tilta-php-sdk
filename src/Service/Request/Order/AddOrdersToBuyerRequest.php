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
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyerRequestModel;
use Tilta\Sdk\Model\Response\Order\AddOrdersToBuyerResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<AddOrdersToBuyerRequestModel, AddOrdersToBuyerResponseModel>
 */
class AddOrdersToBuyerRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/orders';
    }

    protected function processSuccess($requestModel, array $responseData): AddOrdersToBuyerResponseModel
    {
        return (new AddOrdersToBuyerResponseModel())->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return AddOrdersToBuyerRequestModel::class;
    }
}
