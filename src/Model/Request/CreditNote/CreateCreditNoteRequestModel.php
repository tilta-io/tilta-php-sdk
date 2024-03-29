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
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
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
    protected static array $_additionalFieldMapping = [
        'creditNoteExternalId' => 'externalId', // from parent
        'buyerExternalId' => false, // path parameter
    ];

    protected string $buyerExternalId;

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    protected function getFieldValidations(): array
    {
        return [
            'lineItems' => static function ($value): string {
                if ($value === []) {
                    throw new InvalidFieldValueException('you should add at least one line-item to the request model');
                }

                return LineItem::class . '[]';
            },
            'orderExternalIds' => static function ($value): string {
                if ($value === []) {
                    throw new InvalidFieldValueException('you should add at least one order-external-id to the request model');
                }

                return 'string[]';
            },
        ];
    }
}
