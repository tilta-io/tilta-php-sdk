<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Order\LineItem;

class InvoiceTest extends AbstractModelTestCase
{
    public function testArray(): void
    {
        $inputData = [
            'external_id' => 'invoice-external-id',
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
        ];

        $model = (new Invoice())->fromArray($inputData);
        $data = $model->toArray();
        static::assertIsArray($data);
        static::assertEquals('invoice-external-id', $model->getInvoiceExternalId());
        static::assertIsArray($model->getOrderExternalIds());
        static::assertCount(3, $model->getOrderExternalIds());
        static::assertEquals('invoice-number', $model->getInvoiceNumber());
        static::assertInstanceOf(DateTime::class, $model->getInvoicedAt());
        static::assertEquals(2023, (int) $model->getInvoicedAt()->format('Y'));
        static::assertEquals(9, (int) $model->getInvoicedAt()->format('m'));
        static::assertEquals(17, (int) $model->getInvoicedAt()->format('d'));
        static::assertInstanceOf(Amount::class, $model->getAmount());
        static::assertInstanceOf(Address::class, $model->getBillingAddress());
        static::assertIsArray($model->getLineItems());
        static::assertCount(2, $model->getLineItems());
        static::assertContainsOnlyInstancesOf(LineItem::class, $model->getLineItems());

        static::assertInputOutputModel($inputData, $model);
    }
}
