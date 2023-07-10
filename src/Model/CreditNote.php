<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTime;
use Tilta\Sdk\Model\Order\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string getCreditNoteExternalId()
 * @method DateTime getInvoicedAt()
 * @method int getAmount()
 * @method string getCurrency()
 * @method Address getBillingAddress()
 * @method LineItem[] getLineItems()
 * @method string getMerchantExternalId()
 */
class CreditNote extends AbstractModel implements HasBuyerFieldInterface
{
    protected string $creditNoteExternalId;

    protected string $buyerExternalId;

    protected DateTime $invoicedAt;

    protected Amount $amount;

    protected string $currency;

    protected Address $billingAddress;

    protected array $lineItems;

    protected array $orderExternalIds;

    protected string $merchantExternalId;

    protected static array $_additionalFieldMapping = [
        'creditNoteExternalId' => 'external_id',
        'invoicedAt' => 'date', // TILLSDK-17: got renamed in a future release
        'buyerExternalId' => 'buyer_id', // TILLSDK-17: got renamed in a future release
        'merchantExternalId' => 'merchant_id', // TILLSDK-17: got renamed in a future release
        'billingAddress' => 'delivery_address', // TILLSDK-15: got renamed in a future release
    ];

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    protected function prepareModelData(array $data): array
    {
        return [
            'lineItems' => static fn (string $key): ?array => ResponseHelper::getArray($data, $key, LineItem::class),
        ];
    }
}
