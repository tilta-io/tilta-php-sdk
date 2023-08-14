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
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\Request\Buyer\GetBuyersListRequestModel;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerListRequest;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetBuyerListRequestTest extends TestCase
{
    public GetBuyerListRequest $requestService;

    protected function setUp(): void
    {
        $this->requestService = new GetBuyerListRequest(TiltaClientHelper::getClient());
    }

    public function testGetList(): void
    {
        $response = $this->requestService->execute(new GetBuyersListRequestModel());

        $this->assertNotNull($response->getOffset());
        $this->assertEquals(0, $response->getOffset());
        $this->assertNotNull($response->getTotal());
        $this->assertIsArray($items = $response->getItems());

        if ($items !== []) {
            // only test this, if at least on item exist.
            $this->assertInstanceOf(Buyer::class, $items[0]);
        }
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetBuyerListRequest::class, GetBuyersListRequestModel::class],
        ];
    }
}
