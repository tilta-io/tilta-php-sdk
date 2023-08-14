<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\SepaMandate;

use Tilta\Sdk\Model\Request\SepaMandate\GetSepaMandateListRequestModel;
use Tilta\Sdk\Model\REsponse\SepaMandate\GetSepaMandateListResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetSepaMandateListRequestModel, GetSepaMandateListResponseModel>
 */
class GetSepaMandateListRequest extends AbstractRequest
{
    protected static function getExpectedRequestModelClass(): string
    {
        return GetSepaMandateListRequestModel::class;
    }

    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/mandates';
    }

    protected function processSuccess($requestModel, array $responseData): GetSepaMandateListResponseModel
    {
        return (new GetSepaMandateListResponseModel())->fromArray($responseData);
    }
}
