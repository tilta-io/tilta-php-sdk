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
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

class OrderTest extends AbstractModelTest
{
    public function testFromArray(): void
    {
        $inputData = [
            'external_id' => 'order-external-id',
            'status' => 'order-status',
            'buyer_external_id' => 'buyer-external-id',
            'merchant_external_id' => 'merchant-external-id',
            'ordered_at' => (new DateTime())->setDate(2023, 05, 25)->getTimestamp(),
            'payment_method' => 'payment-method',
            'amount' => ResponseHelper::PHPUNIT_OBJECT,
            'comment' => 'order-comment',
            'delivery_address' => ResponseHelper::PHPUNIT_OBJECT,
            'line_items' => [
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
            ],
        ];

        $model = (new Order())->fromArray($inputData);
        static::assertEquals('order-external-id', $model->getOrderExternalId());
        static::assertEquals('order-status', $model->getStatus());
        static::assertEquals('buyer-external-id', $model->getBuyerExternalId());
        static::assertEquals('merchant-external-id', $model->getMerchantExternalId());
        static::assertInstanceOf(DateTime::class, $model->getOrderedAt());
        static::assertEquals(2023, (int) $model->getOrderedAt()->format('Y'));
        static::assertEquals(05, (int) $model->getOrderedAt()->format('m'));
        static::assertEquals(25, (int) $model->getOrderedAt()->format('d'));
        static::assertEquals('payment-method', $model->getPaymentMethod());
        static::assertInstanceOf(Amount::class, $model->getAmount());
        static::assertEquals('order-comment', $model->getComment());
        static::assertInstanceOf(Address::class, $model->getDeliveryAddress());
        static::assertIsArray($model->getLineItems());
        static::assertCount(3, $model->getLineItems());
        foreach ($model->getLineItems() as $item) {
            static::assertInstanceOf(LineItem::class, $item);
        }
    }
}
