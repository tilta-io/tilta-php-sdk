<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Invoice;

use Throwable;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Tilta\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\InvoiceHelper;

class CreateInvoiceRequestTest extends AbstractRequestTestCase
{
    public function testCreateInvoiceOffline(): void
    {
        $client = $this->createMockedTiltaClientResponse(InvoiceHelper::createValidInvoice('invoice-external-id')->toArray());

        $responseModel = (new CreateInvoiceRequest($client))->execute($this->createMock(CreateInvoiceRequestModel::class));
        static::assertEquals('invoice-external-id', $responseModel->getInvoiceExternalId());
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
        $model = $this->createMock(CreateInvoiceRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new CreateInvoiceRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            // TODO implement
        ];
    }
}
