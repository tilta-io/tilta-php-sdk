<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Util;

use PHPUnit\Framework\TestCase;
use stdClass;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Attributes\Validation\Enum;
use Tilta\Sdk\Attributes\Validation\Required;
use Tilta\Sdk\Attributes\Validation\StringLength;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\SimpleTestModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\ValidationOverrideTestModel;
use Tilta\Sdk\Util\Validation;

class ValidationTest extends TestCase
{
    /**
     * @dataProvider requiredFieldsDataProvider
     */
    public function testRequiredFields(string $field, string $valueToSet): void
    {
        $model = new class() extends AbstractModel {
            #[DefaultField]
            protected string $field;

            #[DefaultField]
            #[Required]
            protected ?string $fieldWithValidation = null;
        };

        Validation::validatePropertyValue($model, $field, $valueToSet);

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, $field, null);
    }

    public function requiredFieldsDataProvider(): array
    {
        return [
            ['field', 'value-should-be-set'],
            ['fieldWithValidation', 'value-should-be-set'],
        ];
    }

    public function testNullable(): void
    {
        $model = new class() extends AbstractModel {
            #[DefaultField]
            protected ?string $field = null;
        };

        Validation::validatePropertyValue($model, 'field', 'value-should-be-set');
        Validation::validatePropertyValue($model, 'field', null);

        static::assertTrue(true); // no exception should get triggered
    }

    public function testInvalidTypes(): void
    {
        $model = new class() extends AbstractModel {
            #[DefaultField]
            protected SimpleTestModel $field;
        };
        Validation::validatePropertyValue($model, 'field', new SimpleTestModel());

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, 'field', new stdClass());
    }

    public function testInvalidTypesNullable(): void
    {
        $model = new class() extends AbstractModel {
            #[DefaultField]
            protected ?SimpleTestModel $field = null;
        };
        Validation::validatePropertyValue($model, 'field', new SimpleTestModel());
        Validation::validatePropertyValue($model, 'field', null);

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, 'field', new stdClass());
    }

    public function testArrayOfTypesValid(): void
    {
        $model = new class() extends AbstractModel {
            #[ListField(expectedItemClass: SimpleTestModel::class)]
            protected array $fieldWithType;

            #[ListField(expectedScalarType: 'string')]
            protected array $fieldWithScalarType;

            #[ListField]
            protected array $fieldWithoutType;
        };

        Validation::validatePropertyValue($model, 'fieldWithoutType', [
            'value1',
            new stdClass(),
            new SimpleTestModel(),
        ]);

        Validation::validatePropertyValue($model, 'fieldWithScalarType', [
            'value1',
            'value2',
        ]);

        Validation::validatePropertyValue($model, 'fieldWithType', [
            new SimpleTestModel(),
            new SimpleTestModel(),
        ]);

        static::assertTrue(true);
    }

    public function testArrayOfTypesInvalidModel(): void
    {
        $model = new class() extends AbstractModel {
            #[ListField(expectedItemClass: SimpleTestModel::class)]
            protected array $field;
        };

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, 'field', [
            new SimpleTestModel(),
            'invalid-value',
        ]);
    }

    public function testArrayOfTypesInvalidScalar(): void
    {
        $model = new class() extends AbstractModel {
            #[ListField(expectedScalarType: 'string')]
            protected array $field;
        };

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, 'field', [
            'valid-value',
            new SimpleTestModel(),
        ]);
    }

    public function testArrayNullableWithTypes(): void
    {
        $model = new class() extends AbstractModel {
            #[ListField(expectedScalarType: 'string')]
            protected ?array $field = null;
        };

        Validation::validatePropertyValue($model, 'field', []);
        Validation::validatePropertyValue($model, 'field', null);
        Validation::validatePropertyValue($model, 'field', [
            'value-1',
            'value-2',
        ]);

        static::assertTrue(true);
    }

    public function testArrayNullableWithInvalidTypes(): void
    {
        $model = new class() extends AbstractModel {
            #[ListField(expectedScalarType: 'string')]
            protected ?array $field = null;
        };

        $this->expectException(InvalidFieldValueException::class);

        Validation::validatePropertyValue($model, 'field', [
            new stdClass(),
            'test',
        ]);
    }

    public function testInvalidProperty(): void
    {
        $this->expectException(InvalidFieldException::class);

        Validation::validatePropertyValue(
            new class() extends AbstractModel {
            },
            'not-existing-field',
            null
        );
    }

    public function testOverrideRequiredField(): void
    {
        // Use case: e.g. Buyer/UpdateBuyerRequestModel:
        // to keep the code clean, we are using the same properties for both models. so we can extend UpdateBuyerRequestModel from Buyer-Model.
        // If we expect the buyer as a response of a request, a few fields are always returned, so these fields are not nullable.
        // For the UpdateBuyerRequestModel all fields are nullable, cause only the fields got updated, which got provided.
        // to prevent copy the whole buyer class, we just override the field validations to make all fields nullable.
        // so a validation of the model will not fail.
        // maybe this is not best-practise and maybe only a workaround. TODO maybe we could improve this in the future.

        $model = new class() extends ValidationOverrideTestModel {
            #[DefaultField]
            #[Required(false)]
            protected string $requiredField;

            #[DefaultField]
            #[Required(true)]
            protected ?string $notRequiredField = null;
        };

        Validation::validatePropertyValue($model, 'requiredField', null);
        Validation::validatePropertyValue($model, 'requiredField', 'valid-value');
        Validation::validatePropertyValue($model, 'notRequiredField', 'valid-value');

        // validation should fail, cause the field is not nullable, and no not-required-flag ist set.
        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, 'notRequiredField', null);
    }

    public function testSuccessfulEnumValidation(): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[Enum(validValues: ['value-1', 'value-2'])]
            protected string $fieldValue;

            #[DefaultField]
            #[Enum(validValues: ['value-1', 'value-2'])]
            protected ?string $fieldValueNullable;
        };

        Validation::validatePropertyValue($model, 'fieldValue', 'value-1');
        Validation::validatePropertyValue($model, 'fieldValue', 'value-2');
        Validation::validatePropertyValue($model, 'fieldValueNullable', 'value-1');
        Validation::validatePropertyValue($model, 'fieldValueNullable', 'value-1');
        // null-value should be accepted
        Validation::validatePropertyValue($model, 'fieldValueNullable', null);

        self::assertTrue(true);
    }

    /**
     * @dataProvider failingEnumValidationDataProvider
     */
    public function testFailingEnumValidation(string $field, mixed $value): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[Enum(validValues: ['value-1', 'value-2'])]
            protected string $fieldValue;

            #[DefaultField]
            #[Enum(validValues: ['value-1', 'value-2'])]
            protected ?string $fieldValueNullable;
        };

        $this->expectException(InvalidFieldValueException::class);
        Validation::validatePropertyValue($model, $field, $value);
    }

    public static function failingEnumValidationDataProvider(): array
    {
        return [
            ['fieldValue', 'invalid-value'],
            ['fieldValue', null],
            ['fieldValue', new stdClass()],
            ['fieldValueNullable', 'invalid-value'],
            ['fieldValueNullable', new stdClass()],
        ];
    }

    public function testStringLengthMinValidation(): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[StringLength(minLength: 2)]
            protected string $fieldValue;
        };

        $model->setFieldValue('ab');
        self::assertEquals('ab', $model->getFieldValue());

        $model->setFieldValue('abc');
        self::assertEquals('abc', $model->getFieldValue());

        $model->setFieldValue('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren');
        self::assertEquals('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren', $model->getFieldValue());

        $this->expectException(InvalidFieldValueException::class);
        $model->setFieldValue('a');
    }

    public function testStringLengthMaxValidation(): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[StringLength(maxLength: 5)]
            protected string $fieldValue;
        };

        $model->setFieldValue('a');
        self::assertEquals('a', $model->getFieldValue());

        $model->setFieldValue('ab');
        self::assertEquals('ab', $model->getFieldValue());

        $model->setFieldValue('abc');
        self::assertEquals('abc', $model->getFieldValue());

        $this->expectException(InvalidFieldValueException::class);
        $model->setFieldValue('Lorem ipsum dolor');
    }

    public function testStringLengthMinMaxValidation(): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[StringLength(minLength: 2, maxLength: 5)]
            protected string $fieldValue;
        };

        $exception = null;
        try {
            $model->setFieldValue('a');
            self::assertEquals('a', $model->getFieldValue());
        } catch (InvalidFieldValueException $invalidFieldValueException) {
            $exception = $invalidFieldValueException;
        }

        self::assertInstanceOf(InvalidFieldValueException::class, $exception);

        $model->setFieldValue('ab');
        self::assertEquals('ab', $model->getFieldValue());

        $model->setFieldValue('abc');
        self::assertEquals('abc', $model->getFieldValue());

        $this->expectException(InvalidFieldValueException::class);
        $model->setFieldValue('Lorem ipsum dolor');
    }
}
