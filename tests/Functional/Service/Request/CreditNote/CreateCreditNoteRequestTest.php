<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\CreditNote;

use Throwable;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\CreditNote\InvoiceForCreditNoteNotFound;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\Request\CreditNote\CreateCreditNoteRequestModel;
use Tilta\Sdk\Service\Request\CreditNote\CreateCreditNoteRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class CreateCreditNoteRequestTest extends AbstractRequestTestCase
{
    public function testCreateCreditNoteOffline(): void
    {
        $client = $this->createMockedTiltaClientResponse([
            'external_id' => 'credit-note-external-id',
            'date' => 1688402226,
            'total_amount' => 100,
            'currency' => 'EUR',
            'delivery_address' => [
                'street' => 'string',
                'house' => 'string',
                'postcode' => '12345',
                'city' => 'string',
                'country' => 'DE',
                'additional' => 'string',
            ],
            'line_items' => [
                [
                    'name' => 'line-item 1',
                    'category' => 'string',
                    'description' => 'string',
                    'price' => 25,
                    'currency' => 'EUR',
                    'quantity' => 2,
                ],
                [
                    'name' => 'line-item 2',
                    'category' => 'string',
                    'description' => 'string',
                    'price' => 50,
                    'currency' => 'EUR',
                    'quantity' => 1,
                ],
            ],
            'buyer_id' => 'buyer-external-id',
            'merchant_id' => 'merchant-external-id',
        ]);

        $responseModel = (new CreateCreditNoteRequest($client))->execute($this->createMock(CreateCreditNoteRequestModel::class));
        static::assertInstanceOf(CreditNote::class, $responseModel);
        static::assertEquals('credit-note-external-id', $responseModel->getCreditNoteExternalId());
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
        $model = $this->createMock(CreateCreditNoteRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new CreateCreditNoteRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['code' => 'NO_INVOICE_FOUND'], InvoiceForCreditNoteNotFound::class],
        ];
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateCreditNoteRequest::class, CreateCreditNoteRequestModel::class],
        ];
    }
}
