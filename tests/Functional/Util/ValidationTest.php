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
use Tilta\Sdk\Tests\Functional\Mock\Model\ValidationOverrideTypeNullTestModel;
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

    public function testOverrideRequiredFieldNotNullable(): void
    {
        // Use case: e.g. Buyer/UpdateBuyerRequestModel:
        // to keep the code clean, we are using the same properties for both models. so we can extend UpdateBuyerRequestModel from Buyer-Model.
        // If we expect the buyer as a response of a request, a few fields are always returned, so these fields are not nullable.
        // For the UpdateBuyerRequestModel all fields are nullable, cause only the fields got updated, which got provided.
        // to prevent copy the whole buyer class, we just override the field validations to make all fields nullable.
        // so a validation of the model will not fail.
        // maybe this is not best-practise and maybe only a workaround. TODO maybe we could improve this in the future.

        // field does have a defined property type of `string`. so it is not possible to set a `null` value on it.
        // the validation process validates the property with reflection first, and after that, against the custom-definition.
        // cause the custom-validation contains an "is not required"-flag the validation should not fail.

        // validate for not-required field
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'notNullableField',
            null,
            Validation::IS_NOT_REQUIRED
        );

        // validation should also not fail if the value is valid
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'notNullableField',
            'value',
            Validation::IS_NOT_REQUIRED
        );

        // validation should fail, cause the field is not nullable, and no not-required-flag ist set.
        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'notNullableField',
            null
        );
    }

    public function testOverrideRequiredFieldNullable(): void
    {
        // please also see comment in testOverrideRequiredFieldNotNullable()

        // should not fail - default behavior
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'nullableField',
            null
        );

        // should also not fail - default behavior
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'nullableField',
            'value'
        );

        // should also not fail - default behavior & explicit flag
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'nullableField',
            null,
            Validation::IS_NOT_REQUIRED
        );

        // should also not fail - default behavior & explicit flag
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'nullableField',
            'value',
            Validation::IS_REQUIRED
        );

        // validation should fail, cause the field is not nullable, and no not-required-flag ist set.
        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue(
            new ValidationOverrideTypeNullTestModel(),
            'nullableField',
            null,
            Validation::IS_REQUIRED
        );
    }
}
