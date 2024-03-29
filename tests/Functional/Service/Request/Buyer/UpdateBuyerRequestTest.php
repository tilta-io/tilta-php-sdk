<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Buyer;

use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel;
use Tilta\Sdk\Model\Request\Buyer\UpdateBuyerRequestModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest;
use Tilta\Sdk\Service\Request\Buyer\UpdateBuyerRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class UpdateBuyerRequestTest extends AbstractRequestTestCase
{
    public CreateBuyerRequest $createRequestService;

    private UpdateBuyerRequest $updateBuyerRequest;

    private GetBuyerDetailsRequest $getBuyerRequest;

    protected function setUp(): void
    {
        $client = TiltaClientHelper::getClient();
        $this->createRequestService = new CreateBuyerRequest($client);
        $this->updateBuyerRequest = new UpdateBuyerRequest($client);
        $this->getBuyerRequest = new GetBuyerDetailsRequest($client);
    }

    public function testUpdateBuyer(): void
    {
        $externalId = 'unit-testing_' . __FUNCTION__ . '_' . round(microtime(true));

        $inputBuyer = BuyerHelper::createValidBuyer($externalId, CreateBuyerRequestModel::class);
        $response = $this->createRequestService->execute($inputBuyer);
        $this->assertTrue($response);

        $updateBuyerModel = new UpdateBuyerRequestModel($externalId);
        $updateBuyerModel->setTradingName('updated trading_name');

        $response = $this->updateBuyerRequest->execute($updateBuyerModel);
        $this->assertTrue($response);

        $buyer = $this->getBuyerRequest->execute(new GetBuyerDetailsRequestModel($externalId));

        // compare input buyer with output. Both buyers should contain exactly the same data.
        $this->assertEquals('updated trading_name', $buyer->getTradingName());
    }

    public function testUpdateBuyerNotFound(): void
    {
        $exception = new NotFoundException('test', 404, [
            'message' => 'No Buyer found',
        ]);
        $client = $this->createMockedTiltaClientException($exception);

        $this->expectException(BuyerNotFoundException::class);
        (new UpdateBuyerRequest($client))->execute(new UpdateBuyerRequestModel('test'));
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [UpdateBuyerRequest::class, UpdateBuyerRequestModel::class],
        ];
    }
}
