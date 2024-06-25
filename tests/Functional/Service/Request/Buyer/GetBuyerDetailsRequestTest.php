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
use Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel;
use Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetBuyerDetailsRequestTest extends AbstractRequestTestCase
{
    public GetBuyerDetailsRequest $requestService;

    protected function setUp(): void
    {
        $this->requestService = new GetBuyerDetailsRequest(TiltaClientHelper::getClient());
    }

    // we wont test the get-buyer request, because it is already tested with the unit-test CreateBuyerRequestTest

    public function testGetBuyerNotFound(): void
    {
        $exception = new NotFoundException('test', 404, [
            'message' => 'No Buyer found',
        ]);
        $client = $this->createMockedTiltaClientException($exception);

        $this->expectException(BuyerNotFoundException::class);
        (new GetBuyerDetailsRequest($client))->execute(new GetBuyerDetailsRequestModel('test'));
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetBuyerDetailsRequest::class, GetBuyerDetailsRequestModel::class],
        ];
    }
}
