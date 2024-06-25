<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Invoice;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Invoice\GetInvoiceListRequestModel;
use Tilta\Sdk\Model\Response\Invoice\GetInvoiceListResponseModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Invoice\GetInvoiceListRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\InvoiceHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetInvoiceListRequestTest extends AbstractRequestTestCase
{
    public function testGetInvoiceListOffline(): void
    {
        $expectedResponse = $this->getDefaultValidResponse();
        $request = new GetInvoiceListRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $response = $request->execute($this->createMock(GetInvoiceListRequestModel::class));
        static::assertInstanceOf(GetInvoiceListResponseModel::class, $response);
        static::assertCount(4, $response->getItems());
        static::assertContainsOnlyInstancesOf(Invoice::class, $response->getItems());
    }

    public function testIfCorrectPathGotUsed(): void
    {
        $requestModelMock = $this->createMock(GetInvoiceListRequestModel::class);
        $requestModelMock->method('getBuyerExternalId')->willReturn('test-buyer-id');
        $clientMock = $this->createMock(TiltaClient::class);
        $clientMock->method('request')->willReturnCallback(function (string $url, array $data): array {
            self::assertEquals('buyers/test-buyer-id/invoices', $url);
            return $this->getDefaultValidResponse();
        });
        (new GetInvoiceListRequest($clientMock))->execute($requestModelMock);

        $requestModelMock = $this->createMock(GetInvoiceListRequestModel::class);
        $requestModelMock->method('getBuyerExternalId')->willReturn('');
        $clientMock = $this->createMock(TiltaClient::class);
        $clientMock->method('request')->willReturnCallback(function (string $url, array $data): array {
            self::assertEquals('invoices', $url);
            return $this->getDefaultValidResponse();
        });
        (new GetInvoiceListRequest($clientMock))->execute($requestModelMock);
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

    public function testGetInvoiceListForBuyerOnline(): void
    {
        $client = TiltaClientHelper::getClient();
        $buyerExternalId = BuyerHelper::createUniqueExternalId(__FUNCTION__);
        $inputBuyer = BuyerHelper::createValidBuyer($buyerExternalId, CreateBuyerRequestModel::class);
        self::assertTrue((new CreateBuyerRequest($client))->execute($inputBuyer));

        $request = new GetInvoiceListRequest($client);

        $model = (new GetInvoiceListRequestModel())
            ->setBuyerExternalId($buyerExternalId)
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

    private function getDefaultValidResponse(): array
    {
        return [
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
    }
}
