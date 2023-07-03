<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Functional\Service\Request\Order;

use Throwable;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\GetOrderDetailsRequestModel;
use Tilta\Sdk\Service\Request\Order\GetOrderDetailsRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\OrderHelper;

class GetOrderDetailsRequestTest extends AbstractRequestTestCase
{
    public function testRequest(): void
    {
        // create mocked client
        $orderId = 'order-id-' . __FUNCTION__;
        $order = OrderHelper::createValidOrder($orderId, 'buyer-id');
        $responseData = $order->toArray();
        $responseData['status'] = 'PENDING';
        $client = $this->createMockedTiltaClientResponse($responseData);

        // execute request
        $responseModel = (new GetOrderDetailsRequest($client))->execute(new GetOrderDetailsRequestModel($orderId));

        // test values
        static::assertInstanceOf(Order::class, $responseModel);
        static::assertEquals($orderId, $responseModel->getOrderExternalId());
    }

    /**
     * @param class-string<Throwable> $expectedException
     * @dataProvider exceptionDataProvider
     */
    public function testExpectException(array $responseData, string $expectedException): void
    {
        $exception = new GatewayException(123, $responseData);
        $client = $this->createMockedTiltaClientException($exception);

        $this->expectException($expectedException);
        $model = $this->createMock(GetOrderDetailsRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new GetOrderDetailsRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['message' => 'No Order found'], OrderNotFoundException::class],
        ];
    }
}
