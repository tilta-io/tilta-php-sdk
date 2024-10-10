<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\CreditNote;

use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\RequestModelInterface;

/**
 * @method $this setCreditNoteExternalId(string $creditNoteExternalId)
 * @method $this setBuyerExternalId(string $buyerExternalId)
 * @method $this setInvoicedAt(DateTimeInterface $invoicedAt)
 * @method $this setAmount(Amount $amount)
 * @method $this setBillingAddress(Address $billingAddress)
 * @method string[] getOrderExternalIds()
 * @method $this setOrderExternalIds(string[] $orderExternalIds)
 * @method $this setLineItems(LineItem[] $lineItems)
 */
class CreateCreditNoteRequestModel extends CreditNote implements HasBuyerFieldInterface, RequestModelInterface
{
    protected string $buyerExternalId;

    #[ListField(expectedScalarType: 'string')]
    protected array $orderExternalIds;

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
