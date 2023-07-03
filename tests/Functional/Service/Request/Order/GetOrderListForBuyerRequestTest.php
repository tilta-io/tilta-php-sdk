<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use Throwable;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\GetOrderListForBuyerRequestModel;
use Tilta\Sdk\Model\Response\Order\GetOrderListForBuyerResponseModel;
use Tilta\Sdk\Service\Request\Order\GetOrderListForBuyerRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\OrderHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetOrderListForBuyerRequestTest extends AbstractRequestTestCase
{
    public function testRequestOffline(): void
    {
        $expectedResponse = [
            OrderHelper::createValidOrderWithStatus('order-1')->toArray(),
            OrderHelper::createValidOrderWithStatus('order-2')->toArray(),
            OrderHelper::createValidOrderWithStatus('order-3')->toArray(),
        ];
        $request = new GetOrderListForBuyerRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $model = (new GetOrderListForBuyerRequestModel('buyer-id'));

        $response = $request->execute($model);
        static::assertInstanceOf(GetOrderListForBuyerResponseModel::class, $response);
        static::assertCount(3, $response->getItems());
        static::assertContainsOnlyInstancesOf(Order::class, $response->getItems());
    }

    public function testRequestOnline(): void
    {
        $buyerId = BuyerHelper::getBuyerExternalIdWithValidFacility(__FUNCTION__);
        $request = new GetOrderListForBuyerRequest(TiltaClientHelper::getClient());

        $model = (new GetOrderListForBuyerRequestModel($buyerId));

        $response = $request->execute($model);
        static::assertInstanceOf(GetOrderListForBuyerResponseModel::class, $response);
        static::assertContainsOnlyInstancesOf(Order::class, $response->getItems());
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
        $model = $this->createMock(GetOrderListForBuyerRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new GetOrderListForBuyerRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['message' => 'No Buyer found'], BuyerNotFoundException::class],
        ];
    }
}
