<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\AbstractRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

abstract class AbstractRequestTestCase extends TestCase
{
    /**
     * @dataProvider dataProviderExpectedRequestModel
     */
    public function testExpectedExceptionOnWrongRequestModelClass(string $requestServiceClass, string $expectedRequestModel): void
    {
        if (!is_subclass_of($requestServiceClass, AbstractRequest::class)) {
            throw new Exception('given request-service class is not a sub-class of ' . AbstractRequest::class);
        }

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/instance of ' . str_replace('\\', '\\\\', $expectedRequestModel) . '/');
        (new $requestServiceClass($this->createMock(TiltaClient::class)))->execute(new class() extends AbstractRequestModel {
        });
    }

    abstract public function dataProviderExpectedRequestModel(): array;

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
        if (str_starts_with($originalClassName, 'Tilta\Sdk\Model\\')) {
            $mock->method('toArray')->willReturn([]);
            $mock->method('validateFields');
        }

        return $mock;
    }
}
