<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Buyer;

use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class CreateBuyerRequestTest extends AbstractRequestTestCase
{
    public CreateBuyerRequest $requestService;

    private GetBuyerDetailsRequest $getRequestService;

    protected function setUp(): void
    {
        $client = TiltaClientHelper::getClient();
        $this->requestService = new CreateBuyerRequest($client);
        $this->getRequestService = new GetBuyerDetailsRequest($client);
    }

    public function testCreateBuyer(): void
    {
        $externalId = BuyerHelper::createUniqueExternalId(__FUNCTION__);

        $inputBuyer = BuyerHelper::createValidBuyer($externalId, CreateBuyerRequestModel::class);
        $response = $this->requestService->execute($inputBuyer);

        $this->assertTrue($response);

        $buyer = $this->getRequestService->execute(new GetBuyerDetailsRequestModel($externalId));

        // compare input buyer with output. Both buyers should contain exactly the same data.
        $this->assertEquals($inputBuyer->toArray(), $buyer->toArray());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetBuyerDetailsRequest::class, GetBuyerDetailsRequestModel::class],
        ];
    }
}
