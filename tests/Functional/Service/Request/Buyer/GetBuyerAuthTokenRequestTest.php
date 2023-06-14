<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Buyer;

use PHPUnit\Framework\TestCase;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerAuthTokenRequest;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetBuyerAuthTokenRequestTest extends TestCase
{
    public GetBuyerAuthTokenRequest $requestService;

    protected function setUp(): void
    {
        $this->requestService = new GetBuyerAuthTokenRequest(TiltaClientHelper::getClient());
    }

    public function testGetToken(): void
    {
        $buyerExternalId = 'test-company'; // company has been created via dashboard. Tests will fail, if buyer got deleted

        $tokenModel = $this->requestService->execute(new GetBuyerAuthTokenRequestModel($buyerExternalId));

        $this->assertNotNull($tokenModel->getBuyerAuthToken());
        $this->assertStringStartsWith('ey', $tokenModel->getBuyerAuthToken());
    }
}
