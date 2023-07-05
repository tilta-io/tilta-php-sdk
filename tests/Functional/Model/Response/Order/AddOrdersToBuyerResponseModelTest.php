<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response\Order;

use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Response\Order\AddOrdersToBuyerResponseModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;
use Tilta\Sdk\Tests\Helper\OrderHelper;

class AddOrdersToBuyerResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $model = (new AddOrdersToBuyerResponseModel())->fromArray([
            OrderHelper::createValidOrderWithStatus('order-1')->toArray(),
            OrderHelper::createValidOrderWithStatus('order-2')->toArray(),
            OrderHelper::createValidOrderWithStatus('order-3')->toArray(),
            OrderHelper::createValidOrderWithStatus('order-4')->toArray(),
        ]);

        static::assertIsArray($model->getItems());
        static::assertCount(4, $model->getItems());
        static::assertContainsOnlyInstancesOf(Order::class, $model->getItems());
    }
}
