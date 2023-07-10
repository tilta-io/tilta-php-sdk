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
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\SepaMandate\CreateSepaMandateRequestModel;
use Tilta\Sdk\Model\Request\SepaMandate\GetSepaMandateListRequestModel;
use Tilta\Sdk\Model\Response\SepaMandate;
use Tilta\Sdk\Model\REsponse\SepaMandate\GetSepaMandateListResponseModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\SepaMandate\CreateSepaMandateRequest;
use Tilta\Sdk\Service\Request\SepaMandate\GetSepaMandateListRequest;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class OtherGatewayRequestTest extends TestCase
{
    protected static string $buyerExternalId;

    private static TiltaClient $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = TiltaClientHelper::getClient();

        $prefixCacheKey = uniqid();
        self::$buyerExternalId = BuyerHelper::createUniqueExternalId('other-tests', $prefixCacheKey);
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
    public function testCreateSepaMandate(): void
    {
        $requestModel = (new CreateSepaMandateRequestModel(self::$buyerExternalId))
            ->setIban('DE02120300000000202051');

        $responseModel = (new CreateSepaMandateRequest(self::$client))->execute($requestModel);
        static::assertInstanceOf(SepaMandate::class, $responseModel);
        static::assertEquals('DE02120300000000202051', $responseModel->getIban());
    }

    /**
     * @depends testCreateBuyer
     */
    public function testFetchSepaMandateList(): void
    {
        $requestModel = (new GetSepaMandateListRequestModel(self::$buyerExternalId));

        $responseModel = (new GetSepaMandateListRequest(self::$client))->execute($requestModel);
        static::assertInstanceOf(GetSepaMandateListResponseModel::class, $responseModel);
        static::assertCount(1, $responseModel->getItems());
        static::assertEquals('DE02120300000000202051', $responseModel->getItems()[0]->getIban());
    }
}
