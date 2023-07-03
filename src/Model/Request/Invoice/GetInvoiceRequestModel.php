<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Invoice;

use Tilta\Sdk\Model\HasInvoiceIdFieldInterface;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

class GetInvoiceRequestModel extends AbstractRequestModel implements HasInvoiceIdFieldInterface
{
    protected string $invoiceExternalId;

    protected static array $_additionalFieldMapping = [
        'invoiceExternalId' => false, // path parameter
    ];

    public function __construct(string $invoiceExternalId)
    {
        parent::__construct();
        $this->invoiceExternalId = $invoiceExternalId;
    }

    public function getInvoiceExternalId(): string
    {
        // we will not call `$this->__call()` because it is impossible to add invalid data to the request model cause the constructor.
        return $this->invoiceExternalId;
    }
}
