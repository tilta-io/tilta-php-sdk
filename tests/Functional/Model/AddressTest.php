<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\Address;

class AddressTest extends AbstractModelTestCase
{
    public function testInvalidCountryToShort(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        (new Address())->setCountry('t')->toArray();
    }

    public function testInvalidCountryToLong(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        (new Address())->setCountry('to long value')->toArray();
    }

    public function testFromAndToArray(): void
    {
        $inputData = [
            'street' => 'company street',
            'house' => 'house number',
            'city' => 'company city',
            'postcode' => '12345',
            'country' => 'DE',
            'additional' => 'additional information',
        ];
        $model = (new Address())->fromArray($inputData);

        $this->assertEquals('company street', $model->getStreet());
        $this->assertEquals('house number', $model->getHouseNumber());
        $this->assertEquals('company city', $model->getCity());
        $this->assertEquals('12345', $model->getPostcode());
        $this->assertEquals('DE', $model->getCountry());
        $this->assertEquals('additional information', $model->getAdditional());

        static::assertInputOutputModel($inputData, $model);
    }
}
