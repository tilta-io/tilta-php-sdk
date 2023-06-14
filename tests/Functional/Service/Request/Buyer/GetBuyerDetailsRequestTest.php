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
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetBuyerDetailsRequestTest extends TestCase
{
    public GetBuyerDetailsRequest $requestService;

    protected function setUp(): void
    {
        $this->requestService = new GetBuyerDetailsRequest(TiltaClientHelper::getClient());
    }

    public function testGetToken(): void
    {
        // buyer has been created via platform. Tests will fail, if buyer got deleted
        // TODO create company by request
        $buyerExternalId = 'test-company';

        $response = $this->requestService->execute(new GetBuyerDetailsRequestModel($buyerExternalId));

        $this->assertNotNull($response->getExternalId());
    }

    public function testNotFound(): void
    {
        $this->expectException(BuyerNotFoundException::class);

        $this->requestService->execute(new GetBuyerDetailsRequestModel('test-123-invalid-id'));
    }
}
