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
use Tilta\Sdk\Exception\GatewayException\Facility\DuplicateFacilityException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\UnexpectedServerResponse;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateFacilityRequestModel, bool>
 */
class CreateFacilityRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getExternalBuyerId() . '/facility';
    }

    protected function processSuccess($requestModel, ?array $responseData = null): bool
    {
        return true;
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
        if ($exception instanceof UnexpectedServerResponse && $exception->getHttpCode() === 409) {
            throw new DuplicateFacilityException($exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
        }

        if ($exception instanceof NotFoundException && $exception->getMessage() === 'No Buyer found') {
            throw new BuyerNotFoundException($requestModel->getExternalBuyerId(), $exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
        }
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }
}
