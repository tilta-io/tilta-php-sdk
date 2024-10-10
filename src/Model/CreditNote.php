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
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Order\LineItem;

/**
 * @method string getCreditNoteExternalId()
 * @method DateTimeInterface getInvoicedAt()
 * @method Amount getAmount()
 * @method Address getBillingAddress()
 * @method LineItem[] getLineItems()
 */
class CreditNote extends AbstractModel
{
    #[DefaultField('external_id')]
    protected string $creditNoteExternalId;

    #[DefaultField]
    protected DateTimeInterface $invoicedAt;

    #[DefaultField]
    protected Amount $amount;

    #[DefaultField]
    protected Address $billingAddress;

    #[ListField(expectedItemClass: LineItem::class)]
    protected array $lineItems;
}
