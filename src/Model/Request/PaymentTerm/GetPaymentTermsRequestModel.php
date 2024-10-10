<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\PaymentTerm;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method $this setBuyerExternalId(string $buyerExternalId)
 * @method $this setMerchantExternalId(string $merchantExternalId)
 * @method Amount getAmount()
 * @method $this setAmount(Amount $amount)
 */
class GetPaymentTermsRequestModel extends AbstractRequestModel implements HasBuyerFieldInterface, HasMerchantFieldInterface
{
    protected string $buyerExternalId;

    #[DefaultField]
    protected string $merchantExternalId;

    protected Amount $amount;

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    protected function _toArray(): array
    {
        $data = parent::_toArray();
        $data['gross_amount'] = $this->amount->getGross();
        $data['currency'] = $this->amount->getCurrency();

        return $data;
    }
}
