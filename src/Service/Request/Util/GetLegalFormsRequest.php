<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Util;

use Exception;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\InvalidRequestException;
use Tilta\Sdk\Model\Request\Util\GetLegalFormsRequestModel;
use Tilta\Sdk\Model\Response\Util\GetLegalFormsResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetLegalFormsRequestModel, GetLegalFormsResponseModel>
 */
class GetLegalFormsRequest extends AbstractRequest
{
    protected static function getExpectedRequestModelClass(): string
    {
        return GetLegalFormsRequestModel::class;
    }

    protected function getPath($requestModel): string
    {
        return 'legal_forms/' . $requestModel->getCountryCode();
    }

    protected function processSuccess($requestModel, array $responseData): GetLegalFormsResponseModel
    {
        return new GetLegalFormsResponseModel($responseData);
    }

    protected function getResponseModelForException($requestModel, Exception $exception): ?GetLegalFormsResponseModel
    {
        if ($exception instanceof GatewayException) {
            $responseData = $exception->getResponseData();
            if ($exception instanceof InvalidRequestException && preg_match('/^country_code: invalid enum value/', $responseData['error'])) {
                return new GetLegalFormsResponseModel();
            }
        }

        return null;
    }
}
