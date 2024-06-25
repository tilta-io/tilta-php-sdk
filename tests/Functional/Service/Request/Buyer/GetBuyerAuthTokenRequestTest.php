<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Buyer;

use PHPUnit\Framework\TestCase;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerAuthTokenRequest;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetBuyerAuthTokenRequestTest extends TestCase
{
    public GetBuyerAuthTokenRequest $requestService;

    private TiltaClient $client;

    protected function setUp(): void
    {
        $this->client = TiltaClientHelper::getClient();
        $this->requestService = new GetBuyerAuthTokenRequest($this->client);
    }

    public function testGetToken(): void
    {
        $buyerExternalId = BuyerHelper::createUniqueExternalId(__FUNCTION__);
        $inputBuyer = BuyerHelper::createValidBuyer($buyerExternalId, CreateBuyerRequestModel::class);
        $this->assertTrue((new CreateBuyerRequest($this->client))->execute($inputBuyer));

        $tokenModel = $this->requestService->execute(new GetBuyerAuthTokenRequestModel($buyerExternalId));

        $this->assertNotNull($tokenModel->getBuyerAuthToken());
        $this->assertStringStartsWith('ey', $tokenModel->getBuyerAuthToken());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetBuyerAuthTokenRequest::class, GetBuyerAuthTokenRequestModel::class],
        ];
    }
}
