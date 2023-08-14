<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Invoice;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class CreateInvoiceRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new CreateInvoiceRequestModel())
            ->setInvoiceExternalId('invoice-external-id')
            ->setInvoiceNumber('invoice-number')
            ->setOrderExternalIds(['order-external-id-1', 'order-external-id-1'])
            ->setInvoicedAt((new DateTime())->setTimestamp(1688401332))
            ->setAmount($this->createMock(Amount::class))
            ->setBillingAddress($this->createMock(Address::class))
            ->setLineItems([
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
            ]);
        $outputData = $model->toArray();

        static::assertIsArray($outputData);
        static::assertCount(7, $outputData);
        static::assertValueShouldBeInData('invoice-external-id', $outputData, 'external_id');
        static::assertValueShouldBeInData(['order-external-id-1', 'order-external-id-1'], $outputData, 'order_external_ids');
        static::assertValueShouldBeInData('invoice-number', $outputData, 'invoice_number');
        static::assertValueShouldBeInData(1688401332, $outputData, 'invoiced_at');
        static::assertValueShouldBeInData([], $outputData, 'amount');
        static::assertValueShouldBeInData([], $outputData, 'billing_address');
        static::assertValueShouldBeInData([[], [], []], $outputData, 'line_items');
    }
}
