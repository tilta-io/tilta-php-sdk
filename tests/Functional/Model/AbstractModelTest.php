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
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\ArrayTestModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\ArrayTestModelFieldMapping;
use Tilta\Sdk\Tests\Functional\Mock\Model\SimpleTestModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\ValidationOverrideTypeNullTestModel;
use Tilta\Sdk\Util\Validation;
use TypeError;

class AbstractModelTest extends AbstractModelTestCase
{
    public function testFromArrayNotNullableFieldsAndDefaultChecks(): void
    {
        $inputData = [
            'date_by_seconds' => 1686847880,
            'int_value' => 6546,
            'float_value' => 546.5464,
            'string_value' => 'my-string',
            'bool_value' => false,
            'object_value' => [
                'field_value' => 'a value',
                'nullable_field_value' => null,
            ],
            'simple_array_value' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'array_with_object_value' => [
                [
                    'field_value' => 'object 1',
                    'nullable_field_value' => null,
                ],
                [
                    'field_value' => 'object 2',
                    'nullable_field_value' => null,
                ],
                [
                    'field_value' => 'object 3',
                    'nullable_field_value' => null,
                ],
            ],
            'nullable_object_value' => [
                'date_by_seconds' => 1686555555,
                'int_value' => 9876,
                'float_value' => 984.5551,
                'string_value' => 'another-string',
                'bool_value' => true,
                'object_value' => [
                    'field_value' => 'another value',
                    'nullable_field_value' => null,
                ],
                'simple_array_value' => [
                    'value 1-1',
                    'value 1-2',
                ],
                'array_with_object_value' => [
                    [
                        'field_value' => 'object 1-1',
                        'nullable_field_value' => null,
                    ],
                    [
                        'field_value' => 'object 1-2',
                        'nullable_field_value' => null,
                    ],
                    [
                        'field_value' => 'object 1-3',
                        'nullable_field_value' => null,
                    ],
                ],
                // nullable values added for `reverse test` - does not have any effect, and will be not tested
                'nullable_date_by_seconds' => null,
                'nullable_int_value' => null,
                'nullable_float_value' => null,
                'nullable_string_value' => null,
                'nullable_object_value' => null,
            ],
            // nullable values added for `reverse test` - does not have any effect, and will be not tested
            'nullable_date_by_seconds' => null,
            'nullable_int_value' => null,
            'nullable_float_value' => null,
            'nullable_string_value' => null,
        ];

        $model = new ArrayTestModel();
        $model->fromArray($inputData);

        $this->assertEquals(1686847880, $model->getDateBySeconds()->getTimestamp());
        $this->assertEquals(6546, $model->getIntValue());
        $this->assertEquals(546.5464, $model->getFloatValue());
        $this->assertEquals('my-string', $model->getStringValue());
        $this->assertFalse($model->getBoolValue());
        $this->assertInstanceOf(SimpleTestModel::class, $model->getObjectValue());
        $this->assertEquals('a value', $model->getObjectValue()->getFieldValue());
        $this->assertNotNull($model->getNullableObjectValue());
        $this->assertTrue($model->getNullableObjectValue()->getBoolValue());

        // test array values
        $this->assertIsArray($model->getSimpleArrayValue());
        $this->assertCount(2, $model->getSimpleArrayValue());

        // test array values with objects
        $this->assertIsArray($model->getArrayWithObjectValue());
        $this->assertCount(3, $model->getArrayWithObjectValue());
        $this->assertInstanceOf(SimpleTestModel::class, $model->getArrayWithObjectValue()[0]);
        $this->assertEquals('object 1', $model->getArrayWithObjectValue()[0]->getFieldValue());
        $this->assertEquals('object 2', $model->getArrayWithObjectValue()[1]->getFieldValue());

        // test array values with objects (in sub-object)
        $subModel = $model->getNullableObjectValue();
        $this->assertNotNull($subModel);
        $this->assertIsArray($subModel->getArrayWithObjectValue());
        $this->assertCount(3, $subModel->getArrayWithObjectValue());
        $this->assertInstanceOf(SimpleTestModel::class, $subModel->getArrayWithObjectValue()[0]);
        $this->assertEquals('value 1-1', $subModel->getSimpleArrayValue()[0]);
        $this->assertEquals('value 1-2', $subModel->getSimpleArrayValue()[1]);

        // reverse test
        $this->doInputOutputDataComparison($model, $inputData);
    }

    public function testFromArrayNullableFields(): void
    {
        $inputData = [
            // required values - got not tested by this test.
            'date_by_seconds' => 1686847880,
            'int_value' => 6546,
            'float_value' => 546.5464,
            'string_value' => 'my-string',
            'bool_value' => false,
            'object_value' => [
                'field_value' => 'a value',
                'nullable_field_value' => null,
            ],
            'simple_array_value' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'array_with_object_value' => [
                [
                    'field_value' => 'object 1',
                    'nullable_field_value' => null,
                ],
                [
                    'field_value' => 'object 2',
                    'nullable_field_value' => null,
                ],
                [
                    'field_value' => 'object 3',
                    'nullable_field_value' => null,
                ],
            ],
            // nullable values
            'nullable_date_by_seconds' => 1686855555,
            'nullable_int_value' => 8888,
            'nullable_float_value' => 7777.7777,
            'nullable_string_value' => 'string which is not null',
            'nullable_object_value' => [
                'date_by_seconds' => 1686555555,
                'int_value' => 9876,
                'float_value' => 984.5551,
                'string_value' => "value in object on a field which could be null, but isn't null",
                'bool_value' => false,
                'object_value' => [
                    'field_value' => 'very deep value',
                    'nullable_field_value' => null,
                ],
                'array_with_object_value' => [
                    [
                        'field_value' => 'object 1-1',
                        'nullable_field_value' => null,
                    ],
                    [
                        'field_value' => 'object 1-2',
                        'nullable_field_value' => null,
                    ],
                    [
                        'field_value' => 'object 1-3',
                        'nullable_field_value' => null,
                    ],
                ],
                'simple_array_value' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                ],
                // nullable values added for `reverse test` - does not have any effect, and will be not tested
                'nullable_date_by_seconds' => null,
                'nullable_int_value' => null,
                'nullable_float_value' => null,
                'nullable_string_value' => null,
                'nullable_object_value' => null,
            ],
        ];

        $model = new ArrayTestModel();
        $model->fromArray($inputData);

        $this->assertEquals(1686855555, $model->getNullableDateBySeconds()->getTimestamp());
        $this->assertEquals(8888, $model->getNullableIntValue());
        $this->assertEquals(7777.7777, $model->getNullableFloatValue());
        $this->assertEquals('string which is not null', $model->getNullableStringValue());
        $this->assertInstanceOf(ArrayTestModel::class, $model->getNullableObjectValue());
        $this->assertEquals("value in object on a field which could be null, but isn't null", $model->getNullableObjectValue()->getStringValue());
        $this->assertEquals('very deep value', $model->getNullableObjectValue()->getObjectValue()->getFieldValue());

        // reverse test
        $this->doInputOutputDataComparison($model, $inputData);
    }

    public function testFieldMapping(): void
    {
        $inputData = [
            'field_which_is_not_in_sdk' => 'value',
        ];

        $model = new ArrayTestModelFieldMapping();
        $model->fromArray($inputData);

        $this->assertEquals('value', $model->getFieldRenamedInSdk());

        // reverse test
        $this->doInputOutputDataComparison($model, $inputData);
    }

    public function testFieldMappingNotMapped(): void
    {
        $inputData = [
            'field_which_is_not_in_sdk' => 'value',
            'field_which_DoEsNotE-xiTAnyw233re' => 'value123',
        ];

        $model = new ArrayTestModelFieldMapping();
        $model->fromArray($inputData);

        $this->assertEquals('value', $model->getFieldRenamedInSdk());
        $this->assertCount(1, $model->toArray());
        $this->assertArrayHasKey('field_which_is_not_in_sdk', $model->toArray());
    }

    public function testOverrideValidationNotNullableField(): void
    {
        $model = new ValidationOverrideTypeNullTestModel();
        $model->setFieldValidation('notNullableField', Validation::IS_NOT_REQUIRED);

        // should not throw an exception, cause Validation-util got the not-required-flag.
        $model->setNotNullableField(null);
        $this->assertNull($model->getNotNullableField()); // value should be null, also if the field is not nullable

        // test if the value got correctly unset, instead of not setting value.
        $model->setNotNullableField('value');
        $this->assertEquals('value', $model->getNotNullableField());
        $model->setNotNullableField(null);
        $this->assertNull($model->getNotNullableField()); // value should be null, also if the field is not nullable
    }

    public function testOverrideValidationNullableField(): void
    {
        $model = new ValidationOverrideTypeNullTestModel();
        $model->setFieldValidation('nullableField', Validation::IS_REQUIRED);

        // should not throw an exception, cause the value is valid
        $model->setNotNullableField('value');
        $this->assertEquals('value', $model->getNotNullableField());

        // should throw type-error exception, because the value would be set without validation
        $model->disableValidateOnSet();
        $this->expectException(TypeError::class);
        $model->setNotNullableField(null);
    }

    public function testOverrideValidationNullableFieldOnSet(): void
    {
        $model = new ValidationOverrideTypeNullTestModel();
        $model->setFieldValidation('nullableField', Validation::IS_REQUIRED);

        // should throw exception, cause value is required by custom definition
        $this->expectException(InvalidFieldValueException::class);
        $model->setNotNullableField(null);
    }

    private function doInputOutputDataComparison(AbstractModel $model, array $inputData): void
    {
        $outputData = $model->toArray();
        $this->recursiveKSort($inputData);
        $this->recursiveKSort($outputData);
        $this->assertEquals($inputData, $outputData);
    }

    private function recursiveKSort(array &$array): void
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursiveKSort($value);
            }
        }

        ksort($array);
    }
}
