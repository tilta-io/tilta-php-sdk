<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Util;

use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use Tilta\Sdk\Attributes\ApiField\DateTimeField;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Attributes\ApiField\ObjectField;
use Tilta\Sdk\Attributes\Validation\Enum;
use Tilta\Sdk\Attributes\Validation\StringLength;
use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\SimpleTestModel;
use Tilta\Sdk\Util\ReflectionHelper;
use Tilta\Sdk\Util\ResponseHelper;

class ResponseHelperTest extends TestCase
{
    /**
     * @dataProvider dataProviderGetString
     * @phpstan-ignore-next-line
     */
    public function testGetStringDP(...$arguments): void
    {
        $this->dynamicTest(new class() extends AbstractModel {
            #[DefaultField]
            protected string $key;
        }, ...$arguments);
    }

    public function dataProviderGetString(): array
    {
        return [
            // should pass - value should be fetched
            ['valid-value', 'valid-value'],
            // should pass - value should be fetched
            ['', ''],
            // should pass - value should be fetched
            // should pass - an int is a valid value - should be converted
            [123456, '123456'],
            // should pass - an int is a valid value - should be converted
            [123456e5, '12345600000'],
            // should pass - a float is a valid value - should be converted
            [123456.789, '123456.789'],
        ];
    }

    /**
     * @dataProvider dataProviderGetInt
     * @phpstan-ignore-next-line
     */
    public function testGetIntDP(...$arguments): void
    {
        $this->dynamicTest(new class() extends AbstractModel {
            #[DefaultField]
            protected int $key;
        }, ...$arguments);
    }

    public function dataProviderGetInt(): array
    {
        return [
            // should pass - valid value
            [123456, 123456],
            // should pass - valid value
            [123456e5, 12345600000],
            // should pass - we will ignore wrong types
            [123456.789, 123456],
            // should FAIL - invalid value
            ['invalid-value', null, true],
        ];
    }

    /**
     * @dataProvider dataProviderGetFloat
     * @phpstan-ignore-next-line
     */
    public function testGetFloatDP(...$arguments): void
    {
        $this->dynamicTest(new class() extends AbstractModel {
            #[DefaultField]
            protected float $key;
        }, ...$arguments);
    }

    public function dataProviderGetFloat(): array
    {
        return [
            // should pass - valid value
            [123456, 123456.00],
            // should pass - valid value
            [123456e5, 12345600000.00],
            // should FAIL - invalid value
            ['invalid-value', null, true],
        ];
    }

    /**
     * @dataProvider dataProviderGetBool
     * @phpstan-ignore-next-line
     */
    public function testGetBoolDP(...$arguments): void
    {
        $this->dynamicTest(new class() extends AbstractModel {
            #[DefaultField]
            protected bool $key;
        }, ...$arguments);
    }

    public function dataProviderGetBool(): array
    {
        return [
            // should pass - valid value
            [true, true],
            // should pass - valid value
            [false, false],
            // should pass - valid value
            [1, true],
            // should pass - valid value
            [0, false],
            // should pass - invalid value got converted to false
            ['invalid-value', false],
            // should pass - invalid value got converted to false
            [20, false],
            // should pass - invalid value got converted to false
            [-20, false],
        ];
    }

    public function testGetDateTimeDP(): void
    {
        $this->dynamicTest(new class() extends AbstractModel {
            #[DateTimeField(format: 'Y-m-d')]
            protected DateTime $key;

            /** @phpstan-ignore-next-line */
        }, givenValue: '2023-05-01', expectedValue: DateTime::createFromFormat('Y-m-d', '2023-05-01')->setTime(0, 0, 0));

        $this->dynamicTest(new class() extends AbstractModel {
            #[DateTimeField(format: 'Y-m-d H:i:s')]
            protected DateTime $key;

            /** @phpstan-ignore-next-line */
        }, givenValue: '2023-05-01 13:45:12', expectedValue: DateTime::createFromFormat('Y-m-d', '2023-05-01')->setTime(13, 45, 12));

        $this->dynamicTest(new class() extends AbstractModel {
            #[DateTimeField(format: 'Y-m-d H:i:s')]
            protected DateTime $key;
        }, givenValue: 'invalid-value', expectedValue: null, expectException: true);

        $this->dynamicTest(new class() extends AbstractModel {
            #[DateTimeField(format: 'invalid-format')]
            protected DateTime $key;
        }, givenValue: '', expectedValue: null, expectException: true);
    }

    /**
     * @dataProvider dataProviderGetArray
     */
    public function testGetArrayDP(array $givenValue, array $expectedValue, bool $isKeyValue): void
    {
        if ($isKeyValue) {
            $model = new class() extends AbstractModel {
                #[ListField]
                protected array $key;
            };
        } else {
            $model = new class() extends AbstractModel {
                #[ListField(expectedItemClass: SimpleTestModel::class)]
                protected array $key;
            };
        }

        $this->dynamicTest($model, $givenValue, $expectedValue, false);
    }

    public function dataProviderGetArray(): array
    {
        return [
            // should pass - valid value
            [[], [], false],
            // should pass - valid value
            [[], [], true],
            // should pass - valid value
            [['key' => 'value'], ['key' => 'value'], true],
            // should pass - valid value
            [[['field_value' => 'value']], [(new SimpleTestModel())->setFieldValue('value')], false],
            // should pass - valid value
            [[['field_value' => 'value'], ['field_value' => 'value2']], [(new SimpleTestModel())->setFieldValue('value'), (new SimpleTestModel())->setFieldValue('value2')], false],
        ];
    }

    /**
     * @dataProvider dataProviderGetObject
     * @phpstan-ignore-next-line
     */
    public function testGetObjectDP(...$arguments): void
    {
        $this->dynamicTest(new class() extends AbstractModel {
            #[ObjectField(responseIsReadOnly: false)]
            protected SimpleTestModel $key;
        }, ...$arguments);
    }

    public function dataProviderGetObject(): array
    {
        return [
            [['field_value' => 'value'], (new SimpleTestModel())->setFieldValue('value')],
            [['field_value' => 'value', 'nullable_field_value' => 'value2'], (new SimpleTestModel())->setFieldValue('value')->setNullableFieldValue('value2')],
            [['field_value' => 'value', 'another-field' => 'something-else'], (new SimpleTestModel())->setFieldValue('value')],
            [['field_value' => 'value', 'nullable_field_value' => 'value2', 'another-field' => 'something-else'], (new SimpleTestModel())->setFieldValue('value')->setNullableFieldValue('value2')],
        ];
    }

    public function testSuccessfulEnumValidation(): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[Enum(validValues: ['value-1', 'value-2'])]
            protected string $fieldValue;
        };

        $model->setFieldValue('value-1');
        self::assertEquals('value-1', $model->getFieldValue());
        $model->setFieldValue('value-2');
        self::assertEquals('value-2', $model->getFieldValue());
    }

    public function testFailingEnumValidation(): void
    {
        $model = new class() extends SimpleTestModel {
            #[DefaultField]
            #[Enum(validValues: ['value-1', 'value-2'])]
            protected string $fieldValue;
        };

        $model->setFieldValue('value-1');
        $this->expectException(InvalidFieldValueException::class);
        $model->setFieldValue('invalid-value');
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

    private function dynamicTest(AbstractModel $model, mixed $givenValue, mixed $expectedValue, bool $expectException = false): void
    {
        // we add another key to make sure, that the response helper will work with multiple keys
        $fieldName = 'key';

        $data = [
            '__another-key-with-some-other-data' => '-/-',
            $fieldName => $givenValue,
        ];

        if ($expectException) {
            static::expectException(InvalidResponseException::class);
        }

        [$property, $fieldDefinition] = ReflectionHelper::getModelApiFields($model)[$fieldName];

        $value = ResponseHelper::getValue($data, $property, $fieldDefinition);

        if ($expectException) {
            return;
        }

        if (is_array($expectedValue)) {
            foreach ($expectedValue as $k => $v) {
                $expectedValue[$k] = $v instanceof AbstractModel ? $v->toArray() : $v;
            }

            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $value[$k] = $v instanceof AbstractModel ? $v->toArray() : $v;
                }
            }
        }

        static::assertEquals($expectedValue, $value);

        $thrownException = null;
        try {
            $data[$fieldName] = null;
            ResponseHelper::getValue($data, $property, $fieldDefinition);
            /** @phpstan-ignore-next-line */
        } catch (Exception $exception) {
            $thrownException = $exception;
        }

        /** @phpstan-ignore-next-line */
        static::assertInstanceOf(InvalidResponseException::class, $thrownException ?: null, 'InvalidResponseException should be thrown');
        /** @phpstan-ignore-next-line */
        static::assertMatchesRegularExpression('/was expected in response/', $thrownException->getMessage());

        static::expectException(InvalidResponseException::class);
        static::expectExceptionMessageMatches('/was expected in response/');
        unset($data[$fieldName]);
        ResponseHelper::getValue($data, $property, $fieldDefinition);
    }
}
