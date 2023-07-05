<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Invoice;

use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Request\Invoice\GetInvoiceListRequestModel;
use Tilta\Sdk\Model\Response\Invoice\GetInvoiceListResponseModel;
use Tilta\Sdk\Service\Request\Invoice\GetInvoiceListRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\InvoiceHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetInvoiceListRequestTest extends AbstractRequestTestCase
{
    public function testGetInvoiceListOffline(): void
    {
        $expectedResponse = [
            'limit' => 5,
            'offset' => 3,
            'total' => 2,
            'items' => [
                InvoiceHelper::createValidInvoice('invoice-1')->toArray(),
                InvoiceHelper::createValidInvoice('invoice-2')->toArray(),
                InvoiceHelper::createValidInvoice('invoice-3')->toArray(),
                InvoiceHelper::createValidInvoice('invoice-4')->toArray(),
            ],
        ];
        $request = new GetInvoiceListRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $response = $request->execute($this->createMock(GetInvoiceListRequestModel::class));
        static::assertInstanceOf(GetInvoiceListResponseModel::class, $response);
        static::assertCount(4, $response->getItems());
        static::assertContainsOnlyInstancesOf(Invoice::class, $response->getItems());
    }

    /**
     * @depends testGetInvoiceListOffline
     */
    public function testGetInvoiceListOnline(): void
    {
        $request = new GetInvoiceListRequest(TiltaClientHelper::getClient());

        $model = (new GetInvoiceListRequestModel())
            ->setLimit(5)
            ->setOffset(3);

        $response = $request->execute($model);
        static::assertInstanceOf(GetInvoiceListResponseModel::class, $response);
        static::assertEquals(5, $response->getLimit());
        static::assertEquals(3, $response->getOffset());
        static::assertIsArray($response->getItems());
        static::assertContainsOnlyInstancesOf(Invoice::class, $response->getItems());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetInvoiceListRequest::class, GetInvoiceListRequestModel::class],
        ];
    }
}
