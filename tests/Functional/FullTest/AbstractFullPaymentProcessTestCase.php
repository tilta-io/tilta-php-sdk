<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\FullTest;

use PHPUnit\Framework\TestCase;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel;
use Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel;
use Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel;
use Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel;
use Tilta\Sdk\Model\Request\Order\GetOrderDetailsRequestModel;
use Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel;
use Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel;
use Tilta\Sdk\Model\Response\Order\GetPaymentTermsResponseModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest;
use Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest;
use Tilta\Sdk\Service\Request\Facility\GetFacilityRequest;
use Tilta\Sdk\Service\Request\Order\CreateOrderRequest;
use Tilta\Sdk\Service\Request\Order\GetOrderDetailsRequest;
use Tilta\Sdk\Service\Request\Order\GetPaymentTermsRequest;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\CreditNoteHelper;
use Tilta\Sdk\Tests\Helper\InvoiceHelper;
use Tilta\Sdk\Tests\Helper\OrderHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class AbstractFullPaymentProcessTestCase extends TestCase
{
    protected static string $buyerExternalId;

    protected static string $orderExternalId;

    protected static string $invoiceExternalId;

    protected static string $creditNoteExternalId;

    protected static TiltaClient $client;

    protected static CreateOrderRequestModel $orderToBePlaced;

    public static function setUpBeforeClass(): void
    {
        $prefixCacheKey = uniqid();
        self::$buyerExternalId = BuyerHelper::createUniqueExternalId('full-test', $prefixCacheKey);
        self::$orderExternalId = OrderHelper::createUniqueExternalId('full-test', $prefixCacheKey);
        self::$invoiceExternalId = InvoiceHelper::createUniqueExternalId('full-test', $prefixCacheKey);
        self::$creditNoteExternalId = CreditNoteHelper::createUniqueExternalId('full-test', $prefixCacheKey);
        self::$client = TiltaClientHelper::getClient();
        self::$orderToBePlaced = OrderHelper::createValidOrder(self::$orderExternalId, self::$buyerExternalId);
    }

    public function testCreateBuyer(): void
    {
        $requestModel = BuyerHelper::createValidBuyer(self::$buyerExternalId, CreateBuyerRequestModel::class);
        $responseModel = (new CreateBuyerRequest(self::$client))->execute($requestModel);
        static::assertTrue($responseModel);
    }

    /**
     * @depends testCreateBuyer
     */
    public function testGetBuyer(): void
    {
        $responseModel = (new GetBuyerDetailsRequest(self::$client))->execute(new GetBuyerDetailsRequestModel(self::$buyerExternalId));
        static::assertInstanceOf(Buyer::class, $responseModel);
        static::assertEquals(self::$buyerExternalId, $responseModel->getBuyerExternalId());
    }

    /**
     * @depends testCreateBuyer
     */
    public function testCreateFacility(): void
    {
        $requestModel = new CreateFacilityRequestModel(self::$buyerExternalId);
        $responseModel = (new CreateFacilityRequest(self::$client))->execute($requestModel);
        static::assertTrue($responseModel);
    }

    /**
     * @depends testCreateFacility
     */
    public function testGetFacility(): void
    {
        $responseModel = (new GetFacilityRequest(self::$client))->execute(new GetFacilityRequestModel(self::$buyerExternalId));
        static::assertInstanceOf(GetFacilityResponseModel::class, $responseModel);
        static::assertEquals(self::$buyerExternalId, $responseModel->getBuyerExternalId());
        static::assertGreaterThan(0, $responseModel->getAvailableAmount());
    }

    /**
     * @depends testCreateFacility
     */
    public function testValidatePaymentTerms(): void
    {
        $requestModel = (new GetPaymentTermsRequestModel())
            ->setBuyerExternalId(self::$orderToBePlaced->getBuyerExternalId())
            ->setMerchantExternalId(self::$orderToBePlaced->getMerchantExternalId())
            ->setAmount(self::$orderToBePlaced->getAmount());
        $responseModel = (new GetPaymentTermsRequest(self::$client))->execute($requestModel);
        static::assertInstanceOf(GetPaymentTermsResponseModel::class, $responseModel);
        static::assertGreaterThan(self::$orderToBePlaced->getAmount()->getGross(), $responseModel->getFacility()->getAvailableAmount(), 'facility is not greater than order amount. so order can not be placed.');
    }

    /**
     * @depends testValidatePaymentTerms
     */
    public function testCreateOrder(): void
    {
        $responseModel = (new CreateOrderRequest(self::$client))->execute(self::$orderToBePlaced);
        static::assertInstanceOf(Order::class, $responseModel);
    }

    /**
     * @depends testCreateOrder
     */
    public function testGetOrder(): void
    {
        $responseModel = (new GetOrderDetailsRequest(self::$client))->execute(new GetOrderDetailsRequestModel(self::$orderToBePlaced->getOrderExternalId()));
        static::assertInstanceOf(Order::class, $responseModel);
        static::assertEquals(self::$orderExternalId, $responseModel->getOrderExternalId());
    }
}
