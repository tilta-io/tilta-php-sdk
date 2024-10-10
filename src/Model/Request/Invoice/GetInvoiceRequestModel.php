<?php
/*
 * Copyright (c) WEBiDEA
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
    public function __construct(
        private readonly string $invoiceExternalId
    ) {
        parent::__construct();
    }

    public function getInvoiceExternalId(): string
    {
        return $this->invoiceExternalId;
    }
}
