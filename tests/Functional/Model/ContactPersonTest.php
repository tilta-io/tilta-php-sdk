<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Functional\Model;

use DateTime;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\ContactPerson;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;
use Tilta\Sdk\Util\ResponseHelper;

class ContactPersonTest extends AbstractModelTestCase
{
    public function testFromAndToArray(): void
    {
        $inputData = [
            'salutation' => 'MR',
            'first_name' => 'test-first-name',
            'last_name' => 'test-last-name',
            'birth_date' => 12345678,
            'email' => 'test@localhost.local',
            'phone' => '0123456789',
            'address' => ResponseHelper::PHPUNIT_OBJECT,
        ];
        $model = new ContactPerson($inputData);

        self::assertEquals('MR', $model->getSalutation());
        self::assertEquals('test-first-name', $model->getFirstName());
        self::assertEquals('test-last-name', $model->getLastName());
        self::assertInstanceOf(DateTime::class, $model->getBirthDate());
        self::assertEquals('test@localhost.local', $model->getEmail());
        self::assertEquals('0123456789', $model->getPhone());
        self::assertInstanceOf(Address::class, $model->getAddress());

        // set mock to skip validation
        $model->setAddress($this->createMock(Address::class));

        self::assertInputOutputModel($inputData, $model);
    }

    /**
     * @dataProvider validSalutationProvider
     */
    public function testValidSalutation(string $allowedSalutation): void
    {
        $model = new ContactPerson();
        $model->setSalutation($allowedSalutation);
        self::assertEquals($allowedSalutation, $model->getSalutation());
    }

    public function validSalutationProvider(): array
    {
        return [
            ['MR'],
            ['MS'],
        ];
    }

    /**
     * @dataProvider invalidSalutationProvider
     */
    public function testInvalidSalutation(string $allowedSalutation): void
    {
        $model = new ContactPerson();
        $this->expectException(InvalidFieldValueException::class);
        $model->setSalutation($allowedSalutation);
    }

    public function invalidSalutationProvider(): array
    {
        return [
            ['invalid-1'],
            ['invalid-2'],
        ];
    }
}
