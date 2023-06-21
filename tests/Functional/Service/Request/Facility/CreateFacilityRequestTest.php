<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Facility;

use Tilta\Sdk\Exception\GatewayException\Facility\DuplicateFacilityException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\UnexpectedServerResponse;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel;
use Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel;
use Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest;
use Tilta\Sdk\Service\Request\Facility\GetFacilityRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class CreateFacilityRequestTest extends AbstractRequestTestCase
{
    private CreateBuyerRequest $createBuyerRequestService;

    private CreateFacilityRequest $createFacilityService;

    private GetFacilityRequest $getFacilityService;

    protected function setUp(): void
    {
        $client = TiltaClientHelper::getClient();
        $this->createBuyerRequestService = new CreateBuyerRequest($client);
        $this->createFacilityService = new CreateFacilityRequest($client);
        $this->getFacilityService = new GetFacilityRequest($client);
    }

    public function testCreateFacility(): void
    {
        /** @var CreateBuyerRequestModel $buyer */
        $buyer = BuyerHelper::fillUpBuyerObject(new CreateBuyerRequestModel(), BuyerHelper::createUniqueExternalId(__FUNCTION__));
        $response = $this->createBuyerRequestService->execute($buyer);
        $this->assertTrue($response);

        $response = $this->createFacilityService->execute(new CreateFacilityRequestModel($buyer->getExternalId()));
        $this->assertTrue($response);

        $facilityResponse = $this->getFacilityService->execute(new GetFacilityRequestModel($buyer->getExternalId()));
        $this->assertInstanceOf(GetFacilityResponseModel::class, $facilityResponse);
        $this->assertEquals($buyer->getExternalId(), $facilityResponse->getBuyerExternalId());
        $this->assertNotNull($facilityResponse->getStatus());
        $this->assertNotNull($facilityResponse->getPendingOrdersAmount());
        $this->assertGreaterThan(0, $facilityResponse->getTotalAmount());
    }

    public function testCreateFacilityDuplicate(): void
    {
        $client = $this->createMockedTiltaClientException(new UnexpectedServerResponse(409));

        $this->expectException(DuplicateFacilityException::class);
        (new CreateFacilityRequest($client))->execute(new CreateFacilityRequestModel('test'));
    }

    public function testCreateFacilityBuyerNotFound(): void
    {
        $client = $this->createMockedTiltaClientException(new NotFoundException('test', 404, [
            // TODO TILSDK-9
            'message' => 'No Buyer found',
        ]));

        $this->expectException(BuyerNotFoundException::class);
        (new CreateFacilityRequest($client))->execute(new CreateFacilityRequestModel('test'));
    }
}
