<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\FullTest;

use Tilta\Sdk\Enum\OrderStatusEnum;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\CancelOrderRequestModel;
use Tilta\Sdk\Service\Request\Order\CancelOrderRequest;

class FullPaymentProcessWithCancelTest extends AbstractFullPaymentProcessTestCase
{
    /**
     * @depends testCreateOrder
     */
    public function testCancelOrder(): void
    {
        $requestModel = (new CancelOrderRequestModel(self::$orderExternalId));
        $responseModel = (new CancelOrderRequest(self::$client))->execute($requestModel);
        static::assertInstanceOf(Order::class, $responseModel);
        static::assertEquals(OrderStatusEnum::CANCELED, $responseModel->getStatus());
    }
}
