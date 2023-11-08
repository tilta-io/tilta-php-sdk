<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\PaymentTerm;

use Tilta\Sdk\Model\Request\PaymentTerm\GetPaymentTermsRequestModel;
use Tilta\Sdk\Model\Response\PaymentTerm\GetPaymentTermsResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetPaymentTermsRequestModel, GetPaymentTermsResponseModel>
 */
class GetPaymentTermsRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/payment_terms';
    }

    protected function processSuccess($requestModel, array $responseData): GetPaymentTermsResponseModel
    {
        return (new GetPaymentTermsResponseModel())->fromArray($responseData);
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetPaymentTermsRequestModel::class;
    }
}
