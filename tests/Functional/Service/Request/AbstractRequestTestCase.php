<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\HttpClient\TiltaClient;

class AbstractRequestTestCase extends TestCase
{
    protected function createMockedTiltaClientException(GatewayException $gatewayException): TiltaClient
    {
        $clientMock = $this->createMock(TiltaClient::class);
        $clientMock->method('request')->willThrowException($gatewayException);

        return $clientMock;
    }

    /**
     * @psalm-return MockObject&TiltaClient
     */
    protected function createMockedTiltaClientResponse(array $responseData)
    {
        $clientMock = $this->createMock(TiltaClient::class);

        $clientMock
            ->expects(static::once())
            ->method('request')
            ->willReturn($responseData);

        return $clientMock;
    }

    protected function createMock(string $originalClassName): MockObject
    {
        $mock = parent::createMock($originalClassName);
        if (strpos($originalClassName, 'Tilta\Sdk\Model\\') === 0) {
            $mock->method('toArray')->willReturn([]);
            $mock->method('validateFields');
        }

        return $mock;
    }
}
