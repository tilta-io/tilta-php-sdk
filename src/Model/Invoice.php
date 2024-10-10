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
 * @method string getInvoiceExternalId()
 * @method string[] getOrderExternalIds()
 * @method string getInvoiceNumber()
 * @method DateTimeInterface getInvoicedAt()
 * @method Amount getAmount()
 * @method Address getBillingAddress()
 * @method LineItem[] getLineItems()
 */
class Invoice extends AbstractModel
{
    #[DefaultField('external_id')]
    protected string $invoiceExternalId;

    /**
     * @var string[]
     */
    #[ListField(expectedScalarType: 'string')]
    protected array $orderExternalIds = [];

    #[DefaultField]
    protected string $invoiceNumber;

    #[DefaultField]
    protected DateTimeInterface $invoicedAt;

    #[DefaultField]
    protected Amount $amount;

    /**
     * @var LineItem[]
     */
    #[ListField(expectedItemClass: LineItem::class)]
    protected array $lineItems = [];

    #[DefaultField]
    protected Address $billingAddress;
}
