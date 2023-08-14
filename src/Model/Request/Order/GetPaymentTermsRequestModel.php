<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

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

    protected string $merchantExternalId;

    protected Amount $amount;

    protected static array $_additionalFieldMapping = [
        'buyerExternalId' => false, // got sent as path-parameter
        'amount' => false,          // got mapped manually
    ];

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

    protected function prepareValuesForGateway(array $data): array
    {
        $data = parent::prepareValuesForGateway($data);
        $data['net_amount'] = $this->amount->getNet();
        $data['gross_amount'] = $this->amount->getGross();
        $data['tax_amount'] = $this->amount->getTax();
        $data['currency'] = $this->amount->getCurrency();

        return $data;
    }
}
