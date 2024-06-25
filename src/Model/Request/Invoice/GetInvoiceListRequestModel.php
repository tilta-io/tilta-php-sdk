<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Invoice;

use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\Request\ListRequestModel;

/**
 * @method $this setMerchantExternalId(?string $merchantExternalId)
 * @method $this setBuyerExternalId(string $buyerExternalId)
 */
class GetInvoiceListRequestModel extends ListRequestModel implements HasMerchantFieldInterface, HasBuyerFieldInterface
{
    protected ?string $merchantExternalId = null;

    protected ?string $buyerExternalId = null;

    protected static array $_additionalFieldMapping = [
        'buyerExternalId' => false, // path parameter
    ];

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__) ?: '';
    }
}
