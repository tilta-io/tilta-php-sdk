<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Facility;

use Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel;
use Tilta\Sdk\Service\Request\Facility\GetFacilityRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class GetFacilityRequestTest extends AbstractRequestTestCase
{
    public function testNothing(): void
    {
        // the testCase CreateFacilityRequestTest also tests the get-facility. so we do not to implement create-buyer, create-facility and get-facility in this test-case (again)
        $this->assertTrue(true);
    }

    public function testGetFacilityBuyerNotFound(): void
    {
        $client = $this->createMockedTiltaClientException(new NotFoundException('test', 404, [
            // TODO TILSDK-9
            'message' => 'No Buyer found',
        ]));

        $this->expectException(BuyerNotFoundException::class);
        (new GetFacilityRequest($client))->execute(new GetFacilityRequestModel('test'));
    }

    public function testGetFacilityNoActiveFacility(): void
    {
        $client = $this->createMockedTiltaClientException(new NotFoundException('test', 404, [
            // TODO TILSDK-9
            'message' => 'No Buyer active Facility found',
        ]));

        $this->expectException(NoActiveFacilityFoundException::class);
        (new GetFacilityRequest($client))->execute(new GetFacilityRequestModel('test'));
    }
}
