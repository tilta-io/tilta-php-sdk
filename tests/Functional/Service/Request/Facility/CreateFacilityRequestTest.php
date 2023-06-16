<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Facility;

use PHPUnit\Framework\TestCase;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class CreateFacilityRequestTest extends TestCase
{
    private CreateBuyerRequest $createBuyerRequestService;

    private CreateFacilityRequest $createFacilityService;

    protected function setUp(): void
    {
        $client = TiltaClientHelper::getClient();
        $this->createBuyerRequestService = new CreateBuyerRequest($client);
        $this->createFacilityService = new CreateFacilityRequest($client);
    }

    public function testCreateFacility(): void
    {
        /** @var CreateBuyerRequestModel $buyer */
        $buyer = BuyerHelper::fillUpBuyerObject(new CreateBuyerRequestModel(), BuyerHelper::createUniqueExternalId(__FUNCTION__));
        $response = $this->createBuyerRequestService->execute($buyer);
        $this->assertTrue($response);

        $response = $this->createFacilityService->execute(new CreateFacilityRequestModel($buyer->getExternalId()));
        $this->assertTrue($response);
    }
}
