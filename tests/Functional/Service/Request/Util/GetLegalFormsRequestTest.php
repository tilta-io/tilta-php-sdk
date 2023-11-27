<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\SepaMandate;

use Tilta\Sdk\Exception\GatewayException\InvalidRequestException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\Util\GetLegalFormsRequestModel;
use Tilta\Sdk\Model\Response\Util\GetLegalFormsResponseModel;
use Tilta\Sdk\Service\Request\Util\GetLegalFormsRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetLegalFormsRequestTest extends AbstractRequestTestCase
{
    public function testDefaultResponse(): void
    {
        $client = $this->createMock(TiltaClient::class);
        $client->method('request')->willReturn([
            ['name' => 'ABC', 'display_name' => 'name 1'],
            ['name' => 'DEF', 'display_name' => 'name 2'],
            ['name' => 'GHI', 'display_name' => 'name 3'],
        ]);
        $service = new GetLegalFormsRequest($client);

        $response = $service->execute(new GetLegalFormsRequestModel('DE'));
        self::assertInstanceOf(GetLegalFormsResponseModel::class, $response);
        self::assertCount(3, $response->getItems());
    }

    public function testIfInvalidCountryCodeGotHandled(): void
    {
        $client = $this->createMock(TiltaClient::class);
        $client->method('request')->willThrowException(new InvalidRequestException(400, [
            'error' => "country_code: invalid enum value. Expected 'DE' | 'AT' | '...', received '...'",
            'code' => 'BAD_REQUEST',
        ], []));
        $service = new GetLegalFormsRequest($client);

        $response = $service->execute(new GetLegalFormsRequestModel('---'));
        self::assertInstanceOf(GetLegalFormsResponseModel::class, $response);
        self::assertCount(0, $response->getItems());
    }

    /**
     * @depends testDefaultResponse
     */
    public function testDefaultResponseOnline(): void
    {
        $service = new GetLegalFormsRequest(TiltaClientHelper::getClient());

        $response = $service->execute(new GetLegalFormsRequestModel('DE')); // DE should be always available on test-gateway
        self::assertInstanceOf(GetLegalFormsResponseModel::class, $response);
        self::assertTrue($response->getItems() !== []);
        self::assertNotNull($response->getDisplayName('DE_GMBH')); // DE_GMBH should be always available on test-gateway
    }

    /**
     * @depends testIfInvalidCountryCodeGotHandled
     */
    public function testIfInvalidCountryCodeGotHandledOnline(): void
    {
        $service = new GetLegalFormsRequest(TiltaClientHelper::getClient());

        $response = $service->execute(new GetLegalFormsRequestModel('----'));
        self::assertInstanceOf(GetLegalFormsResponseModel::class, $response);
        self::assertCount(0, $response->getItems());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetLegalFormsRequest::class, GetLegalFormsRequestModel::class],
        ];
    }
}
