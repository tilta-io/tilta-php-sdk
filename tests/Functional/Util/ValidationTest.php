<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Util;

use PHPUnit\Framework\TestCase;
use stdClass;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Tests\Functional\Mock\Model\ValidationTestModel;
use Tilta\Sdk\Util\Validation;

class ValidationTest extends TestCase
{
    public function testRequiredFields(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'requiredStringField',
            'value-should-be-set'
        );

        $this->expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'requiredStringField',
            null
        );
    }

    public function testNullable(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'notRequiredStringField',
            'value-should-be-set'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'notRequiredStringField',
            null
        );

        $this->assertTrue(true); // just an empty test
    }

    public function testCallbackRequired(): void
    {
        $that = $this;
        $callback = static function (...$arguments) use ($that): string {
            $that->assertCount(2, $arguments);
            $that->assertInstanceOf(ValidationTestModel::class, $arguments[0]);
            $that->assertNull($arguments[1]);

            return 'string';
        };

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'callbackValidationField',
            null,
            $callback
        );
    }

    public function testCallbackNotRequired(): void
    {
        $that = $this;
        $callback = static function (...$arguments) use ($that): string {
            $that->assertCount(2, $arguments);
            $that->assertInstanceOf(ValidationTestModel::class, $arguments[0]);
            $that->assertNull($arguments[1]);

            return Validation::TYPE_STRING_OPTIONAL;
        };

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'callbackValidationField',
            null,
            $callback
        );

        $this->assertTrue(true);
    }

    public function testInvalidTypes(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedClassField',
            new stdClass()
        );

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedClassField',
            new ValidationTestModel()
        );
    }

    public function testInvalidTypesNullable(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedNullableClassField',
            new stdClass()
        );

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'expectedNullableClassField',
            new ValidationTestModel()
        );
    }

    public function testArrayOfTypesValid(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                'value1',
                'value2',
            ],
            'string[]'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                new stdClass(),
                new stdClass(),
            ],
            stdClass::class . '[]'
        );

        $this->assertTrue(true);
    }

    public function testArrayOfTypesInvalid(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                new stdClass(),
                'value2',
            ],
            'string[]'
        );
    }

    public function testArrayNullableWithTypes(): void
    {
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            [],
            '?' . stdClass::class . '[]'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            null,
            '?' . stdClass::class . '[]'
        );

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            [
                new stdClass(),
                new stdClass(),
            ],
            '?' . stdClass::class . '[]'
        );

        $this->assertTrue(true);
    }

    public function testArrayNullableWithInvalidTypes(): void
    {
        $this->expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateNullableArray',
            [
                new stdClass(),
                'test',
            ],
            '?' . stdClass::class . '[]'
        );
    }

    public function testArrayOfTypesInvalidInstance(): void
    {
        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'validateArray',
            [
                'value1',
                'value2',
            ],
            stdClass::class . '[]'
        );
    }

    public function testInvalidProperty(): void
    {
        $this->expectException(InvalidFieldException::class);

        Validation::validatePropertyValue(
            new ValidationTestModel(),
            'not-existing-field',
            null
        );
    }
}
