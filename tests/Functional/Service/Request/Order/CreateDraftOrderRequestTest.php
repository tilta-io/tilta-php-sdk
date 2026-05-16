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
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\Order\CreateDraftOrderRequestModel;
use Tilta\Sdk\Service\Request\Order\CreateDraftOrderRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class CreateDraftOrderRequestTest extends AbstractRequestTestCase
{
    public function testCreateDraftOrderOffline(): void
    {
        $responseData = [
            'external_id' => 'order-draft-1',
            'status' => 'DRAFT',
            'buyer_external_id' => 'buyer-123',
            'merchant_external_id' => 'merchant-xyz',
            'ordered_at' => null,
            'payment_method' => null,
            'payment_term' => null,
            'amount' => [
                'gross' => 10000,
                'net' => 8403,
                'tax' => 1597,
                'currency' => 'EUR',
            ],
            'comment' => null,
            'delivery_address' => null,
            'custom_data' => null,
            'line_items' => [],
            'contact_email' => null,
            'created_at' => 1716000000,
            'updated_at' => 1716000000,
        ];

        $client = $this->createMockedTiltaClientResponse($responseData);
        $response = (new CreateDraftOrderRequest($client))->execute($this->createMock(CreateDraftOrderRequestModel::class));

        static::assertInstanceOf(Order::class, $response);
        static::assertEquals('order-draft-1', $response->getOrderExternalId());
        static::assertEquals('DRAFT', $response->getStatus());
        static::assertNull($response->getOrderedAt());
        static::assertNull($response->getPaymentMethod());
        static::assertNull($response->getPaymentTerm());
        static::assertEquals(10000, $response->getAmount()->getGross());
    }

    public function testRequestBodySerialisation(): void
    {
        $model = (new CreateDraftOrderRequestModel())
            ->setOrderExternalId('order-abc')
            ->setBuyerExternalId('buyer-123')
            ->setMerchantExternalId('merchant-xyz')
            ->setAmount(
                (new Amount())->setGross(10000)->setNet(8403)->setTax(1597)->setCurrency('EUR')
            )
            ->setLineItems([
                (new LineItem())->setName('Item 1')->setCategory('cat')->setPrice(10000)->setCurrency('EUR')->setQuantity(1),
            ])
            ->setComment('test comment')
            ->setContactEmail('buyer@example.com');

        $data = $model->toArray();

        static::assertArrayHasKey('external_id', $data);
        static::assertEquals('order-abc', $data['external_id']);
        static::assertArrayHasKey('buyer_external_id', $data);
        static::assertArrayHasKey('merchant_external_id', $data);
        static::assertArrayHasKey('amount', $data);
        static::assertArrayHasKey('line_items', $data);
        static::assertArrayHasKey('comment', $data);
        static::assertArrayHasKey('contact_email', $data);
        static::assertArrayNotHasKey('status', $data);
        static::assertArrayNotHasKey('ordered_at', $data);
        static::assertArrayNotHasKey('payment_method', $data);
        static::assertArrayNotHasKey('payment_term', $data);
    }

    /**
     * @param class-string<Throwable> $expectedException
     * @dataProvider exceptionDataProvider
     */
    public function testExpectException(array $responseData, string $expectedException): void
    {
        $exception = new NotFoundException('buyer-123', 404, $responseData);
        $client = $this->createMockedTiltaClientException($exception);

        $this->expectException($expectedException);
        $model = $this->createMock(CreateDraftOrderRequestModel::class);
        $model->method('toArray')->willReturn([]);
        $model->method('getBuyerExternalId')->willReturn('buyer-123');
        (new CreateDraftOrderRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['error' => 'No Entity found', 'code' => 'NOT_FOUND'], BuyerNotFoundException::class],
        ];
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateDraftOrderRequest::class, CreateDraftOrderRequestModel::class],
        ];
    }
}
