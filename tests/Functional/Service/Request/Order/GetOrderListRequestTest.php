<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\GetOrderListRequestModel;
use Tilta\Sdk\Model\Response\Order\GetOrderListResponseModel;
use Tilta\Sdk\Service\Request\Order\GetOrderListRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;
use Tilta\Sdk\Util\ResponseHelper;

class GetOrderListRequestTest extends AbstractRequestTestCase
{
    public function testGetOrderListOffline(): void
    {
        $expectedResponse = [
            'limit' => 5,
            'offset' => 3,
            'total' => 2,
            'items' => [
                [
                    'external_id' => 'order-1',
                    'status' => 'status-1',
                    'buyer_external_id' => 'buyer-external-id-1',
                    'merchant_external_id' => 'merchant-external-id-1',
                    'ordered_at' => 1687935508,
                    'payment_method' => 'payment-method-1',
                    'amount' => ResponseHelper::PHPUNIT_OBJECT,
                    'comment' => 'order-comment-1',
                    'delivery_address' => ResponseHelper::PHPUNIT_OBJECT,
                    'line_items' => [
                        ResponseHelper::PHPUNIT_OBJECT,
                        ResponseHelper::PHPUNIT_OBJECT,
                    ],
                ],
                [
                    'external_id' => 'order-2',
                    'status' => 'status-2',
                    'buyer_external_id' => 'buyer-external-id-2',
                    'merchant_external_id' => 'merchant-external-id-2',
                    'ordered_at' => 1687935508,
                    'payment_method' => 'payment-method-2',
                    'amount' => ResponseHelper::PHPUNIT_OBJECT,
                    'comment' => 'order-comment-2',
                    'delivery_address' => ResponseHelper::PHPUNIT_OBJECT,
                    'line_items' => [
                        ResponseHelper::PHPUNIT_OBJECT,
                        ResponseHelper::PHPUNIT_OBJECT,
                    ],
                ],
            ],
        ];
        $request = new GetOrderListRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $model = (new GetOrderListRequestModel())
            ->setLimit(5)
            ->setOffset(3);

        $response = $request->execute($model);
        static::assertInstanceOf(GetOrderListResponseModel::class, $response);
        static::assertCount(2, $response->getItems());
        static::assertContainsOnlyInstancesOf(Order::class, $response->getItems());
    }

    /**
     * @depends testGetOrderListOffline
     */
    public function testGetOrderListOnline(): void
    {
        $request = new GetOrderListRequest(TiltaClientHelper::getClient());

        $model = (new GetOrderListRequestModel())
            ->setLimit(5)
            ->setOffset(3);

        $response = $request->execute($model);
        static::assertInstanceOf(GetOrderListResponseModel::class, $response);
        static::assertEquals(5, $response->getLimit());
        static::assertEquals(3, $response->getOffset());
        static::assertIsArray($response->getItems());
        static::assertContainsOnlyInstancesOf(Order::class, $response->getItems());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetOrderListRequest::class, GetOrderListRequestModel::class],
        ];
    }
}
