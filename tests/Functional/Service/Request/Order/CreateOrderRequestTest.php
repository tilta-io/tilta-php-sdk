<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use Throwable;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\Facility\FacilityExceededException;
use Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException;
use Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel;
use Tilta\Sdk\Service\Request\Order\CreateOrderRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\OrderHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class CreateOrderRequestTest extends AbstractRequestTestCase
{
    public function testCreateOrder(): void
    {
        $client = TiltaClientHelper::getClient();
        $buyerExternalId = BuyerHelper::getBuyerExternalIdWithValidFacility(__FUNCTION__);

        $createOrderModel = OrderHelper::createValidOrder(OrderHelper::createUniqueExternalId(__FUNCTION__), $buyerExternalId);
        $response = (new CreateOrderRequest($client))->execute($createOrderModel);

        $inputData = $createOrderModel->toArray();
        $inputData['status'] = 'PENDING_CONFIRMATION';
        ksort($inputData);
        $responseData = $response->toArray();
        ksort($responseData);

        static::assertEquals($inputData, $responseData, 'the response model should contain the same values as the request model. expect the additional status.');
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
        $model = $this->createMock(CreateOrderRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new CreateOrderRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['code' => 'NO_ACTIVE_FACILITY_FOUND'], NoActiveFacilityFoundException::class],
            [['code' => 'FACILITY_EXCEEDED_AVAILABLE_AMOUNT'], FacilityExceededException::class],
            [['message' => 'No Buyer found'], BuyerNotFoundException::class],
            [['message' => 'No Merchant found'], MerchantNotFoundException::class],
        ];
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateOrderRequest::class, CreateOrderRequestModel::class],
        ];
    }
}
