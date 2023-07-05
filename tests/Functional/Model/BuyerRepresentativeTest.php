<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response\Buyer;

use DateTime;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\BuyerRepresentative;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;
use Tilta\Sdk\Util\ResponseHelper;

class BuyerRepresentativeTest extends AbstractModelTestCase
{
    public function testFromAndToArray(): void
    {
        $inputData = [
            'salutation' => 'MR',
            'first_name' => 'first name',
            'last_name' => 'last name',
            'birth_date' => 1686761444,
            'email' => 'abcdef@egagaifg.de',
            'phone' => '0113456789',
            'address' => ResponseHelper::PHPUNIT_OBJECT,
        ];
        $model = (new BuyerRepresentative())->fromArray($inputData);

        $this->assertEquals('MR', $model->getSalutation());
        $this->assertEquals('first name', $model->getFirstName());
        $this->assertEquals('last name', $model->getLastName());
        $this->assertInstanceOf(DateTime::class, $model->getBirthDate());
        $this->assertEquals('abcdef@egagaifg.de', $model->getEmail());
        $this->assertEquals('0113456789', $model->getPhone());
        $this->assertInstanceOf(Address::class, $model->getAddress());

        // unset address to skip validation
        $model->setAddress($this->createMock(Address::class));

        $this->assertInputOutputModel($inputData, $model);
    }

    public function testInvalidSalutation(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        (new BuyerRepresentative())->setSalutation('invalid value')->toArray();
    }
}
