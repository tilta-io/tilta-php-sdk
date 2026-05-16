<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use DateTime;
use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Util\ResponseHelper;

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
            'contact_persons' => [],
            'business_identifiers' => [],
            'business_address' => ResponseHelper::PHPUNIT_OBJECT,
            'custom_data' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'created_at' => null,
            'updated_at' => null,
            'max_days_past_due' => null,
        ];
        $model = new Buyer($inputData);

        self::assertEquals('external id', $model->getExternalId());
        self::assertEquals('trading name', $model->getTradingName());
        self::assertEquals('legal name', $model->getLegalName());
        self::assertEquals('legal form', $model->getLegalForm());
        self::assertInstanceOf(DateTime::class, $model->getRegisteredAt());
        self::assertInstanceOf(DateTime::class, $model->getIncorporatedAt());
        self::assertIsArray($model->getContactPersons());

        // set mock to skip validation
        $model->setBusinessAddress($this->createMock(Address::class));

        self::assertInputOutputModel($inputData, $model);
    }

    public function testRequiredFieldContactPersons(): void
    {
        $inputData = $this->getRequiredFieldValues();
        unset($inputData['contact_persons']);

        $model = new Buyer();
        $this->expectException(InvalidResponseException::class);
        $model->fromArray($inputData);
    }

    public function testRequiredFieldBusinessAddress(): void
    {
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
            'contact_persons' => [],
            'business_address' => [],
        ];
    }
}
