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
use Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel;
use Tilta\Sdk\Model\Response\Order\GetPaymentTermsResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetPaymentTermsRequestModel, GetPaymentTermsResponseModel>
 */
class GetPaymentTermsRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/orders/paymentterms';
    }

    protected function processSuccess($requestModel, array $responseData): GetPaymentTermsResponseModel
    {
        return (new GetPaymentTermsResponseModel())->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetPaymentTermsRequestModel::class;
    }
}
