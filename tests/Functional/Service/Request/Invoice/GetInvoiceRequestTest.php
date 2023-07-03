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
use Tilta\Sdk\Exception\GatewayException\NotFoundException\InvoiceNotFoundException;
use Tilta\Sdk\Model\Request\Invoice\GetInvoiceRequestModel;
use Tilta\Sdk\Service\Request\Invoice\GetInvoiceRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\InvoiceHelper;

class GetInvoiceRequestTest extends AbstractRequestTestCase
{
    public function testGetInvoiceOffline(): void
    {
        $client = $this->createMockedTiltaClientResponse(InvoiceHelper::createValidInvoice('invoice-external-id')->toArray());

        $responseModel = (new GetInvoiceRequest($client))->execute($this->createMock(GetInvoiceRequestModel::class));
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
        $model = $this->createMock(GetInvoiceRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new GetInvoiceRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['message' => 'No Invoice found'], InvoiceNotFoundException::class],
        ];
    }
}
