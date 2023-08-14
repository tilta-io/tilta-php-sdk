<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order;

use BadMethodCallException;
use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class CreateOrderRequestModelTest extends AbstractModelTestCase
{
    public function testArray(): void
    {
        $model = (new CreateOrderRequestModel())
            ->setOrderExternalId('order-external-id')
            ->setBuyerExternalId('buyer-external-id')
            ->setMerchantExternalId('merchant-external-id')
            ->setAmount($this->createMock(Amount::class))
            ->setComment('order-comment')
            ->setOrderedAt((new DateTime())->setDate(2023, 2, 5))
            ->setPaymentMethod('payment-method')
            ->setDeliveryAddress($this->createMock(Address::class))
            ->setLineItems([
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
            ]);

        $data = $model->toArray();
        static::assertIsArray($data);
        static::assertArrayNotHasKey('status', $data);
        static::assertValueShouldBeInData('order-external-id', $data, 'external_id');
        static::assertValueShouldBeInData('buyer-external-id', $data, 'buyer_external_id');
        static::assertValueShouldBeInData('merchant-external-id', $data, 'merchant_external_id');
        static::assertValueShouldBeInData((new DateTime())->setDate(2023, 2, 5)->getTimestamp(), $data, 'ordered_at');
        static::assertValueShouldBeInData([], $data, 'amount'); // object is mocked
        static::assertValueShouldBeInData('order-comment', $data, 'comment');
        static::assertValueShouldBeInData([], $data, 'delivery_address'); // object is mocked
        static::assertArrayHasKey('line_items', $data);
        static::assertIsArray($data['line_items']);
        static::assertCount(3, $data['line_items']);
    }

    public function testDisallowedMethodSetStatus(): void
    {
        $this->expectException(BadMethodCallException::class);
        (new CreateOrderRequestModel())->setStatus('');
    }

    public function testDisallowedMethodGetStatus(): void
    {
        $this->expectException(BadMethodCallException::class);
        (new CreateOrderRequestModel())->getStatus();
    }
}
