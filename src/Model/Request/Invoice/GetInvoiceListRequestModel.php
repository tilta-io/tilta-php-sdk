<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Invoice;

use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\Request\ListRequestModel;

/**
 * @method $this setMerchantExternalId(?string $merchantExternalId)
 */
class GetInvoiceListRequestModel extends ListRequestModel implements HasMerchantFieldInterface
{
    protected ?string $merchantExternalId = null;

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
