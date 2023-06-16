<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Facility;

use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\InvalidResponseException;
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
        return 'buyers/' . $requestModel->getExternalBuyerId() . '/facility';
    }

    protected function processSuccess($requestModel, ?array $responseData = null): GetFacilityResponseModel
    {
        if (!is_array($responseData)) {
            throw new InvalidResponseException('got no response from gateway. A response was expected.');
        }

        return new GetFacilityResponseModel($responseData);
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return BuyerNotFoundException::class;
    }
}
