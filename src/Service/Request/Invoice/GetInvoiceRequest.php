<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Invoice;

use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Request\Invoice\GetInvoiceRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetInvoiceRequestModel, Invoice>
 */
class GetInvoiceRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices/' . $requestModel->getInvoiceExternalId();
    }

    protected function processSuccess($requestModel, array $responseData): Invoice
    {
        return (new Invoice())->fromArray($responseData);
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetInvoiceRequestModel::class;
    }
}
