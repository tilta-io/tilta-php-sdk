<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order;

use Tilta\Sdk\Enum\OrderStatusEnum;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyerRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;
use Tilta\Sdk\Tests\Helper\OrderHelper;

class AddOrdersToBuyerRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new AddOrdersToBuyerRequestModel('buyer-external-id'))
            ->setItems([
                OrderHelper::createValidOrderWithStatus($orderId1 = OrderHelper::createUniqueExternalId(__FUNCTION__), OrderStatusEnum::CANCELED, ExistingOrder::class),
                OrderHelper::createValidOrderWithStatus($orderId2 = OrderHelper::createUniqueExternalId(__FUNCTION__), OrderStatusEnum::CANCELED, ExistingOrder::class),
            ])
            ->addOrderItem(OrderHelper::createValidOrderWithStatus($orderId3 = OrderHelper::createUniqueExternalId(__FUNCTION__), OrderStatusEnum::CANCELED, ExistingOrder::class));

        $data = $model->toArray();
        static::assertIsArray($data);
        static::assertCount(3, $data);
        static::assertValueShouldBeInData($orderId1, $data[0], 'external_id');
        static::assertValueShouldBeInData($orderId2, $data[1], 'external_id');
        static::assertValueShouldBeInData($orderId3, $data[2], 'external_id');
    }
}
