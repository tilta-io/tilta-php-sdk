<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Helper;

use DateTime;
use Tilta\Sdk\Model\Invoice;

class InvoiceHelper extends AbstractHelper
{
    public static function createValidInvoice(string $invoiceExternalId): Invoice
    {
        return (new Invoice())->fromArray([
            'external_id' => $invoiceExternalId,
            'order_external_ids' => [
                'order-external-id-1',
                'order-external-id-2',
                'order-external-id-3',
            ],
            'invoice_number' => 'invoice-number',
            'invoiced_at' => (new DateTime())->setDate(2023, 9, 17)->format('U'),
            'amount' => [
                'currency' => 'EUR',
                'gross' => 119,
                'net' => 100,
                'tax' => 19,
            ],
            'line_items' => [
                [
                    'name' => 'line-item-1',
                    'category' => 'category 1',
                    'description' => 'description 1',
                    'price' => 150,
                    'currency' => 'EUR',
                    'quantity' => 5,
                ],
                [
                    'name' => 'line-item-2',
                    'category' => 'category 2',
                    'description' => 'description 2',
                    'price' => 300,
                    'currency' => 'EUR',
                    'quantity' => 2,
                ],
            ],
            'billing_address' => [
                'street' => 'street',
                'house' => 'house-number',
                'postcode' => '12345',
                'city' => 'city',
                'country' => 'DE',
                'additional' => 'additional address details',
            ],
        ]);
    }

    public static function createUniqueExternalId(string $testName, string $prefixCacheKey = null): string
    {
        return parent::createUniqueExternalId($testName, $prefixCacheKey) . '-invoice';
    }
}
