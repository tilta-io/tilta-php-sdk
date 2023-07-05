<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Facility;

use Exception;
use Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel;
use Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetFacilityRequestModel, GetFacilityResponseModel>
 */
class GetFacilityRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/facility';
    }

    protected function processSuccess($requestModel, array $responseData): GetFacilityResponseModel
    {
        return new GetFacilityResponseModel($responseData);
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
        if ($exception instanceof NotFoundException) {
            if ($exception->getMessage() === 'No Buyer active Facility found') {
                throw new NoActiveFacilityFoundException($requestModel->getBuyerExternalId(), $exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
            } elseif ($exception->getMessage() === 'No Buyer found') {
                throw new BuyerNotFoundException($requestModel->getBuyerExternalId(), $exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
            }
        }
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetFacilityRequestModel::class;
    }
}
