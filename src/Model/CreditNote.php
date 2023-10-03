<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTimeInterface;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string getCreditNoteExternalId()
 * @method DateTimeInterface getInvoicedAt()
 * @method Amount getAmount()
 * @method Address getBillingAddress()
 * @method LineItem[] getLineItems()
 */
class CreditNote extends AbstractModel
{
    protected string $creditNoteExternalId;

    protected DateTimeInterface $invoicedAt;

    protected Amount $amount;

    protected Address $billingAddress;

    protected array $lineItems;

    protected array $orderExternalIds;

    protected static array $_additionalFieldMapping = [
        'creditNoteExternalId' => 'external_id',
    ];

    protected function prepareModelData(array $data): array
    {
        return [
            'lineItems' => static fn (string $key): ?array => ResponseHelper::getArray($data, $key, LineItem::class),
        ];
    }
}
