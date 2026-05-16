<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Buyer;

use Throwable;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerOnboardingSessionRequestModel;
use Tilta\Sdk\Model\Response\SessionResponseModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerOnboardingSessionRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class CreateBuyerOnboardingSessionRequestTest extends AbstractRequestTestCase
{
    public function testCreateSessionOffline(): void
    {
        $responseData = [
            'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.test',
            'url' => 'https://onboarding.tilta.io?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.test',
        ];

        $client = $this->createMockedTiltaClientResponse($responseData);
        $response = (new CreateBuyerOnboardingSessionRequest($client))->execute(
            $this->createMock(CreateBuyerOnboardingSessionRequestModel::class)
        );

        static::assertInstanceOf(SessionResponseModel::class, $response);
        static::assertEquals($responseData['token'], $response->getToken());
        static::assertEquals($responseData['url'], $response->getUrl());
    }

    public function testRequestBodySerialisation(): void
    {
        $model = new CreateBuyerOnboardingSessionRequestModel('buyer-123');
        static::assertEquals([], $model->toArray(), 'empty body when no URLs set');

        $model->setSuccessUrl('https://shop.example.com/success');
        $model->setErrorUrl('https://shop.example.com/error');

        $data = $model->toArray();
        static::assertArrayHasKey('success_url', $data);
        static::assertArrayHasKey('error_url', $data);
        static::assertEquals('https://shop.example.com/success', $data['success_url']);
        static::assertEquals('https://shop.example.com/error', $data['error_url']);
    }

    /**
     * @param class-string<Throwable> $expectedException
     * @dataProvider exceptionDataProvider
     */
    public function testExpectException(array $responseData, string $expectedException): void
    {
        $exception = new NotFoundException('buyer-123', 404, $responseData);
        $client = $this->createMockedTiltaClientException($exception);

        $this->expectException($expectedException);
        $model = $this->createMock(CreateBuyerOnboardingSessionRequestModel::class);
        $model->method('toArray')->willReturn([]);
        $model->method('getBuyerExternalId')->willReturn('buyer-123');
        (new CreateBuyerOnboardingSessionRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['error' => 'No Entity found', 'code' => 'NOT_FOUND'], BuyerNotFoundException::class],
        ];
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateBuyerOnboardingSessionRequest::class, CreateBuyerOnboardingSessionRequestModel::class],
        ];
    }
}
