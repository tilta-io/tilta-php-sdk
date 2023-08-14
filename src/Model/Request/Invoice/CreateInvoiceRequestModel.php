<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Invoice;

use DateTimeInterface;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\RequestModelInterface;

/**
 * @method $this setInvoiceExternalId(string $invoiceExternalId)
 * @method $this setOrderExternalIds(string[] $orderExternalIds)
 * @method $this setInvoiceNumber(string $invoiceNumber)
 * @method $this setInvoicedAt(DateTimeInterface $invoicedAt)
 * @method $this setAmount(Amount $amount)
 * @method $this setBillingAddress(Address $billingAddress)
 * @method $this setLineItems(LineItem[] $lineItems)
 */
class CreateInvoiceRequestModel extends Invoice implements RequestModelInterface
{
    protected function getFieldValidations(): array
    {
        return [
            'lineItems' => static function ($value): string {
                if ($value === []) {
                    throw new InvalidFieldValueException('you should add at least one line-item to the request model');
                }

                return LineItem::class . '[]';
            },
        ];
    }
}
