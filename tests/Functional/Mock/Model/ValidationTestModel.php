<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Mock\Model;

use stdClass;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method self setRequiredStringField(string $requiredField)
 * @method string getRequiredStringField()
 *
 * @method self setNotRequiredStringField(string|null $requiredField)
 * @method string|null getNotRequiredStringField()
 *
 * @method self setExpectedClassField(string $expectedClassField)
 * @method stdClass getExpectedClassField()
 *
 * @method self setExpectedNullableClassField(string|null $expectedClassField)
 * @method stdClass|null getExpectedNullableClassField()
 *
 * @method self setCallbackValidationField($value)
 * @method mixed getCallbackValidationField()
 *
 * @method self setValidateArray(array $list)
 * @method array getValidateArray()
 *
 * @method self setValidateNullableArray(array|null $list)
 * @method array|null getValidateNullableArray()
 *
 * @method self setValidateOverrideNullableFieldValidation($value)
 * @method string|null getValidateOverrideNullableFieldValidation()
 */
class ValidationTestModel extends AbstractRequestModel
{
    protected string $requiredStringField;

    protected ?string $notRequiredStringField = null;

    protected stdClass $expectedClassField;

    protected ?stdClass $expectedNullableClassField = null;

    /**
     * @var mixed
     */
    protected $callbackValidationField;

    protected array $validateArray = [];

    protected ?array $validateNullableArray = [];

    private array $fieldValidations = [];

    /**
     * @param string|callable|null $validation
     */
    public function setFieldValidation(string $field, $validation): void
    {
        $this->fieldValidations[$field] = $validation;
    }

    protected function getFieldValidations(): array
    {
        return $this->fieldValidations;
    }
}
