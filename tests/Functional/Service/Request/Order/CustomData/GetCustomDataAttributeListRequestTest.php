<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order\CustomData;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Order\CustomDataAttribute;
use Tilta\Sdk\Model\Request\Order\CustomData\GetCustomDataAttributeListRequestModel;
use Tilta\Sdk\Model\Response\Order\CustomData\GetCustomDataAttributeListResponse;
use Tilta\Sdk\Service\Request\Order\CustomData\GetCustomDataAttributeListRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;
use Tilta\Sdk\Util\ResponseHelper;

class GetCustomDataAttributeListRequestTest extends AbstractRequestTestCase
{
    public function testGetListOffline(): void
    {
        $client = $this->createMock(TiltaClient::class);
        $client->method('request')->willReturn([
            'limit' => 100,
            'offset' => 0,
            'total' => 3,
            'items' => [
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
            ],
        ]);

        $response = (new GetCustomDataAttributeListRequest($client))->execute(new GetCustomDataAttributeListRequestModel());

        self::assertInstanceOf(GetCustomDataAttributeListResponse::class, $response);
        self::assertCount(3, $response->getItems());
    }

    /**
     * @depends testGetListOffline
     * @depends Tilta\Sdk\Tests\Functional\Service\Request\Order\CustomData\CreateCustomDataAttributeRequestTest::testCreateCustomDataAttribute
     */
    public function testGetListOnline(): void
    {
        $client = TiltaClientHelper::getClient();
        $response = (new GetCustomDataAttributeListRequest($client))->execute(new GetCustomDataAttributeListRequestModel());

        self::assertInstanceOf(GetCustomDataAttributeListResponse::class, $response);
        self::assertGreaterThanOrEqual(1, $response->getItems(), 'there should be at least one custom-data-attribute because of previous/depended test.');
        self::assertContainsOnlyInstancesOf(CustomDataAttribute::class, $response->getItems());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetCustomDataAttributeListRequest::class, GetCustomDataAttributeListRequestModel::class],
        ];
    }
}
