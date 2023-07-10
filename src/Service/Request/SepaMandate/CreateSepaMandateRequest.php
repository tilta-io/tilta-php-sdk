<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\SepaMandate;

use Exception;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\SepaMandate\DuplicateSepaMandateException;
use Tilta\Sdk\Exception\GatewayException\SepaMandate\InvalidIbanException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\SepaMandate\CreateSepaMandateRequestModel;
use Tilta\Sdk\Model\Response\SepaMandate;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateSepaMandateRequestModel, SepaMandate>
 */
class CreateSepaMandateRequest extends AbstractRequest
{
    protected static function getExpectedRequestModelClass(): string
    {
        return CreateSepaMandateRequestModel::class;
    }

    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/mandates';
    }

    protected function processSuccess($requestModel, array $responseData): SepaMandate
    {
        // the iban is not returned by the create-request. Added it to fill the model with more useful data
        $responseData['iban'] ??= $requestModel->getIban();

        return (new SepaMandate())->fromArray($responseData);
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
        if ($exception instanceof GatewayException) {
            if ($exception->getTiltaCode() === 'CONFLICT') {
                throw new DuplicateSepaMandateException($exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
            }

            if ($exception->getHttpCode() === 400 && $exception->getMessage() === 'iban: iban is not valid') {
                throw new InvalidIbanException($exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
            }
        }
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }
}
