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
use Tilta\Sdk\Enum\OrderStatusEnum;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\Facility\FacilityExceededException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyerRequestModel;
use Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel;
use Tilta\Sdk\Model\Response\Order\AddOrdersToBuyerResponseModel;
use Tilta\Sdk\Service\Request\Order\AddOrdersToBuyerRequest;
use Tilta\Sdk\Service\Request\Order\GetPaymentTermsRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\OrderHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class AddOrdersToBuyerRequestTest extends AbstractRequestTestCase
{
    public function testAddOrdersToBuyerOffline(): void
    {
        $expectedResponse = [
            OrderHelper::createValidOrderWithStatus(OrderHelper::createUniqueExternalId(__FUNCTION__))->toArray(),
            OrderHelper::createValidOrderWithStatus(OrderHelper::createUniqueExternalId(__FUNCTION__))->toArray(),
            OrderHelper::createValidOrderWithStatus(OrderHelper::createUniqueExternalId(__FUNCTION__))->toArray(),
        ];
        $request = new AddOrdersToBuyerRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $response = $request->execute($this->createMock(AddOrdersToBuyerRequestModel::class));
        static::assertInstanceOf(AddOrdersToBuyerResponseModel::class, $response);
        static::assertCount(3, $response->getItems());
        static::assertContainsOnlyInstancesOf(Order::class, $response->getItems());
    }

    public function testAddOrdersToBuyerOnline(): void
    {
        $request = new AddOrdersToBuyerRequest(TiltaClientHelper::getClient());

        $buyerId = BuyerHelper::getBuyerExternalIdWithValidFacility(__FUNCTION__);
        $model = (new AddOrdersToBuyerRequestModel($buyerId))
            ->setItems([
                OrderHelper::createValidOrderWithStatus(OrderHelper::createUniqueExternalId(__FUNCTION__) . '-1', OrderStatusEnum::CLOSED, ExistingOrder::class),
                OrderHelper::createValidOrderWithStatus(OrderHelper::createUniqueExternalId(__FUNCTION__) . '-2', OrderStatusEnum::CLOSED, ExistingOrder::class),
                OrderHelper::createValidOrderWithStatus(OrderHelper::createUniqueExternalId(__FUNCTION__) . '-3', OrderStatusEnum::CLOSED, ExistingOrder::class),
            ]);

        $response = $request->execute($model);
        static::assertInstanceOf(AddOrdersToBuyerResponseModel::class, $response);
        static::assertIsArray($response->getItems());
        static::assertCount(3, $response->getItems());
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
        $model = $this->createMock(GetPaymentTermsRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new GetPaymentTermsRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['message' => 'No Buyer found'], BuyerNotFoundException::class],
            [['message' => 'No Merchant found'], MerchantNotFoundException::class],
            [['message' => 'No Merchants with external_id [test123-456üäö] found'], MerchantNotFoundException::class],
            [['code' => 'FACILITY_EXCEEDED_AVAILABLE_AMOUNT'], FacilityExceededException::class],
        ];
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetPaymentTermsRequest::class, GetPaymentTermsRequestModel::class],
        ];
    }
}
