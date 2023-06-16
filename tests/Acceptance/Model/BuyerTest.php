<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model;

use DateTime;
use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Buyer;

class BuyerTest extends AbstractModelTestCase
{
    public function testFromAndToArray(): void
    {
        $inputData = [
            'external_id' => 'external id',
            'trading_name' => 'trading name',
            'legal_name' => 'legal name',
            'legal_form' => 'legal form',
            'registered_at' => 1686763038,
            'incorporated_at' => 1686763038,
            'representatives' => [],
            'business_address' => [],
            'custom_data' => [],
        ];
        $model = new Buyer($inputData);

        $this->assertEquals('external id', $model->getExternalId());
        $this->assertEquals('trading name', $model->getTradingName());
        $this->assertEquals('legal name', $model->getLegalName());
        $this->assertEquals('legal form', $model->getLegalForm());
        $this->assertInstanceOf(DateTime::class, $model->getRegisteredAt());
        $this->assertInstanceOf(DateTime::class, $model->getIncorporatedAt());
        $this->assertIsArray($model->getRepresentatives());

        // set mock to skip validation
        $model->setBusinessAddress($this->createMock(Address::class));

        $outputData = $model->toArray();

        // sort array to make sure they are in the same order
        ksort($inputData);
        ksort($outputData);

        $this->assertEquals($inputData, $outputData);
    }

    public function testRequiredFieldRegisteredAt(): void
    {
        // special case: UpdateBuyerRequestModel: we defined this field as required for the model `Buyer` with custom-validation-definition
        $inputData = $this->getRequiredFieldValues();
        unset($inputData['registered_at']);

        $model = new Buyer();
        $this->expectException(InvalidResponseException::class);
        $model->fromArray($inputData);
    }

    public function testRequiredFieldRepresentatives(): void
    {
        // special case: UpdateBuyerRequestModel: we defined this field as required for the model `Buyer` with custom-validation-definition
        $inputData = $this->getRequiredFieldValues();
        unset($inputData['representatives']);

        $model = new Buyer();
        $this->expectException(InvalidResponseException::class);
        $model->fromArray($inputData);
    }

    public function testRequiredFieldBusinessAddress(): void
    {
        // special case: UpdateBuyerRequestModel: we defined this field as required for the model `Buyer` with custom-validation-definition
        $inputData = $this->getRequiredFieldValues();
        unset($inputData['business_address']);

        $model = new Buyer();
        $this->expectException(InvalidResponseException::class);
        $model->fromArray($inputData);
    }

    private function getRequiredFieldValues(): array
    {
        return [
            'registered_at' => 1686763038,
            'representatives' => [],
            'business_address' => [],
        ];
    }
}
