<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\CreditNote;

use Exception;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\CreditNote\InvoiceForCreditNoteNotFound;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\Request\CreditNote\CreateCreditNoteRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateCreditNoteRequestModel, CreditNote>
 */
class CreateCreditNoteRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId() . '/creditnotes';
    }

    protected function processSuccess($requestModel, array $responseData): CreditNote
    {
        return (new CreditNote())->fromArray($responseData);
    }

    protected function processFailed($requestModel, Exception $exception): void
    {
        if ($exception instanceof GatewayException && $exception->getTiltaCode() === 'NO_INVOICE_FOUND') {
            throw new InvoiceForCreditNoteNotFound($exception->getHttpCode(), $exception->getResponseData(), $exception->getRequestData());
        }
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CreateCreditNoteRequestModel::class;
    }
}
