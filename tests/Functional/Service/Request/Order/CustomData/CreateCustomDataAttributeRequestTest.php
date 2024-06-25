<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order\CustomData;

use Tilta\Sdk\Exception\GatewayException\ConflictException;
use Tilta\Sdk\Model\Order\CustomDataAttribute;
use Tilta\Sdk\Service\Request\Order\CustomData\CreateCustomDataAttributeRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class CreateCustomDataAttributeRequestTest extends AbstractRequestTestCase
{
    public function testCreateCustomDataAttribute(): void
    {
        $client = TiltaClientHelper::getClient();
        $requestModel = new CustomDataAttribute();
        $requestModel->setName('field1-' . uniqid());
        $requestModel->setDataType(CustomDataAttribute::DATA_TYPE_STRING);
        $requestModel->setDescription('field created by unit-testing');

        $response = (new CreateCustomDataAttributeRequest($client))->execute($requestModel);
        self::assertEquals($requestModel->toArray(), $response->toArray());
    }

    public function testIfConflictExceptionGotThrown(): void
    {
        $client = TiltaClientHelper::getClient();
        $requestModel = new CustomDataAttribute();
        $requestModel->setName('field1-' . uniqid());
        $requestModel->setDataType(CustomDataAttribute::DATA_TYPE_STRING);
        $requestModel->setDescription('field created by unit-testing');

        $response = (new CreateCustomDataAttributeRequest($client))->execute($requestModel);
        self::assertInstanceOf(CustomDataAttribute::class, $response);

        $this->expectException(ConflictException::class);
        (new CreateCustomDataAttributeRequest($client))->execute($requestModel);
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateCustomDataAttributeRequest::class, CustomDataAttribute::class],
        ];
    }
}
