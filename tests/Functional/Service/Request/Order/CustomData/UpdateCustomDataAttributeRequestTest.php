<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order\CustomData;

use Tilta\Sdk\Model\Order\CustomDataAttribute;
use Tilta\Sdk\Model\Request\Order\CustomData\UpdateCustomDataAttributeRequestModel;
use Tilta\Sdk\Service\Request\Order\CustomData\CreateCustomDataAttributeRequest;
use Tilta\Sdk\Service\Request\Order\CustomData\UpdateCustomDataAttributeRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class UpdateCustomDataAttributeRequestTest extends AbstractRequestTestCase
{
    public function testUpdateCustomDataAttribute(): void
    {
        $client = TiltaClientHelper::getClient();
        $createRequestModel = new CustomDataAttribute();
        $createRequestModel->setName('field1-' . uniqid());
        $createRequestModel->setDataType(CustomDataAttribute::DATA_TYPE_STRING);
        $createRequestModel->setDescription('field created by unit-testing');

        $response = (new CreateCustomDataAttributeRequest($client))->execute($createRequestModel);
        self::assertInstanceOf(CustomDataAttribute::class, $response);

        $updateRequestModel = new UpdateCustomDataAttributeRequestModel();
        $updateRequestModel->setName($response->getName());
        $updateRequestModel->setDescription('updated description');
        $updateRequestModel->setDataType(CustomDataAttribute::DATA_TYPE_BOOLEAN);

        $response = (new UpdateCustomDataAttributeRequest($client))->execute($updateRequestModel);
        self::assertInstanceOf(CustomDataAttribute::class, $response);
        self::assertEquals('updated description', $response->getDescription());
        self::assertEquals(CustomDataAttribute::DATA_TYPE_BOOLEAN, $response->getDataType());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [UpdateCustomDataAttributeRequest::class, UpdateCustomDataAttributeRequestModel::class],
        ];
    }
}
