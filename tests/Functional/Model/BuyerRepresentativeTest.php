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
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\ContactPerson;
use Tilta\Sdk\Util\ResponseHelper;

class BuyerRepresentativeTest extends AbstractModelTestCase
{
    public function testFromAndToArray(): void
    {
        $model = $this->getValidModel();

        $this->assertEquals('MR', $model->getSalutation());
        $this->assertEquals('first name', $model->getFirstName());
        $this->assertEquals('last name', $model->getLastName());
        $this->assertInstanceOf(DateTime::class, $model->getBirthDate());
        $this->assertEquals('abcdef@egagaifg.de', $model->getEmail());
        $this->assertEquals('0113456789', $model->getPhone());
        $this->assertInstanceOf(Address::class, $model->getAddress());

        // unset address to skip validation
        $model->setAddress($this->createMock(Address::class));

        $this->assertInputOutputModel($this->getValidModelData(), $model);
    }

    public function testInvalidSalutation(): void
    {
        $model = $this->getValidModel()
            ->setValidateOnSet(true);
        $this->expectException(InvalidFieldValueException::class);
        $model->setSalutation('invalidValue');
    }

    public function testValidSalutation(): void
    {
        $model = $this->getValidModel()
            ->setValidateOnSet(true);
        $model->setSalutation('MR');
        static::assertEquals('MR', $model->getSalutation());
        $model->setSalutation('MS');
        static::assertEquals('MS', $model->getSalutation());
    }

    private function getValidModelData(): array
    {
        return [
            'salutation' => 'MR',
            'first_name' => 'first name',
            'last_name' => 'last name',
            'birth_date' => 1686761444,
            'email' => 'abcdef@egagaifg.de',
            'phone' => '0113456789',
            'address' => ResponseHelper::PHPUNIT_OBJECT,
        ];
    }

    private function getValidModel(): ContactPerson
    {
        return (new ContactPerson())->fromArray($this->getValidModelData());
    }
}
