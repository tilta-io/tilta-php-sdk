<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Invoice;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<CreateInvoiceRequestModel, Invoice>
 */
class CreateInvoiceRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices';
    }

    protected function processSuccess($requestModel, array $responseData): Invoice
    {
        return (new Invoice())->fromArray($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return CreateInvoiceRequestModel::class;
    }
}
