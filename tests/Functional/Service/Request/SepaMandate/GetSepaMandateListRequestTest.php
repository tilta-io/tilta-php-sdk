<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\SepaMandate;

use Tilta\Sdk\Model\Request\SepaMandate\GetSepaMandateListRequestModel;
use Tilta\Sdk\Model\Response\SepaMandate;
use Tilta\Sdk\Model\REsponse\SepaMandate\GetSepaMandateListResponseModel;
use Tilta\Sdk\Service\Request\SepaMandate\GetSepaMandateListRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class GetSepaMandateListRequestTest extends AbstractRequestTestCase
{
    public function testRequest(): void
    {
        $expectedResponse = [
            'limit' => 5,
            'offset' => 3,
            'total' => 3,
            'items' => [
                ['mandate_id' => 'mandate 1', 'iban' => 'DE1234567898765', 'created_at' => 1688993333],
                ['mandate_id' => 'mandate 2', 'iban' => 'DE987544664244', 'created_at' => 1688995555],
                ['mandate_id' => 'mandate 3', 'iban' => 'DE12387424838765', 'created_at' => 1688994444],
            ],
        ];
        $request = new GetSepaMandateListRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $response = $request->execute($this->createMock(GetSepaMandateListRequestModel::class));
        static::assertInstanceOf(GetSepaMandateListResponseModel::class, $response);
        static::assertCount(3, $response->getItems());
        static::assertContainsOnlyInstancesOf(SepaMandate::class, $response->getItems());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetSepaMandateListRequest::class, GetSepaMandateListRequestModel::class],
        ];
    }
}
