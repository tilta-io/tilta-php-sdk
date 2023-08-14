<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Invoice;

use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Response\ListResponseModel;

/**
 * @extends ListResponseModel<Invoice>
 */
class GetInvoiceListResponseModel extends ListResponseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct(Invoice::class, $data);
    }
}
