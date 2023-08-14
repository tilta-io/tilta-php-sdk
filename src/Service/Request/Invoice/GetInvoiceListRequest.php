<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Invoice;

use Tilta\Sdk\Model\Request\Invoice\GetInvoiceListRequestModel;
use Tilta\Sdk\Model\Response\Invoice\GetInvoiceListResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetInvoiceListRequestModel, GetInvoiceListResponseModel>
 */
class GetInvoiceListRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices';
    }

    protected function processSuccess($requestModel, array $responseData): GetInvoiceListResponseModel
    {
        return (new GetInvoiceListResponseModel())->fromArray($responseData);
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetInvoiceListRequestModel::class;
    }
}
