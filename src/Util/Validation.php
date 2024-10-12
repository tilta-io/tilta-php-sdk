<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use ReflectionType;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Attributes\Validation\Enum;
use Tilta\Sdk\Attributes\Validation\Required;
use Tilta\Sdk\Attributes\Validation\StringLength;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\AbstractModel;

class Validation
{
    /**
     * @throws InvalidFieldException
     * @throws InvalidFieldValueException
     */
    public static function validatePropertyValue(AbstractModel $model, string $propertyName, mixed $value): void
    {
        try {
            self::validateByReflection($model, $propertyName, $value);
            self::additionalFieldValidation($model, $propertyName, $value);
        } catch (InvalidFieldValueException $invalidFieldValueException) {
            $invalidFieldValueException->setMessage(
                sprintf('The field %s::%s has an invalid value. ', $model::class, $propertyName) .
                $invalidFieldValueException->getMessage()
            );
            throw $invalidFieldValueException;
        }
    }

    /**
     * @throws InvalidFieldException
     * @throws InvalidFieldValueException
     */
    private static function validateByReflection(AbstractModel $model, string $property, mixed $value): void
    {
        $modelReflection = ReflectionHelper::getModelApiFields($model, true);
        if (!is_array($modelReflection[$property] ?? null)) {
            throw new InvalidFieldException($property, $model);
        }

        [$reflectionProperty, $fieldDefinition, $validations] = $modelReflection[$property];

        $reflectionType = $reflectionProperty->getType();
        // method_exist: also see: https://github.com/phpstan/phpstan/issues/1133
        if (!$reflectionType instanceof ReflectionType || !method_exists($reflectionType, 'getName')) {
            return;
        }

        $reflectionTypeName = $reflectionType->getName();

        if ($value === null) {
            $requiredValidation = $validations->getValidation(Required::class);

            if (
                (!$reflectionType->allowsNull() && !$requiredValidation instanceof Required)
                || ($reflectionType->allowsNull() && $requiredValidation && $requiredValidation->isRequired())
            ) {
                throw new InvalidFieldValueException(
                    sprintf('The property %s::%s does not accept a null-value.', $model::class, $property)
                );
            }

            return;
        }

        if ($reflectionTypeName === 'array') {
            self::validateSimpleValue('array', $value);

            if ($fieldDefinition instanceof ListField) {
                $expectedType = $fieldDefinition->getExpectedItemClass() ?: $fieldDefinition->getExpectedScalarType();
                if ($expectedType !== null && $expectedType !== '' && is_array($value)) {
                    foreach ($value as $_value) {
                        self::validateSimpleValue($expectedType, $_value);
                    }
                }
            }
        } else {
            self::validateSimpleValue($reflectionTypeName, $value);
        }
    }

    private static function getErrorMessage(string $expectedType, mixed $value): string
    {
        return sprintf('Expected type: %s. Given type: %s', $expectedType, get_debug_type($value));
    }

    /**
     * @throws InvalidFieldValueException
     * @noinspection PhpDocMissingThrowsInspection
     */
    private static function validateSimpleValue(string $expectedType, mixed $value): void
    {
        $typeErrorMessage = self::getErrorMessage($expectedType, $value);

        $expectedType = self::mapType($expectedType);

        if (class_exists($expectedType) || interface_exists($expectedType)) {
            if (!is_object($value) || !$value instanceof $expectedType) {
                throw new InvalidFieldValueException($typeErrorMessage);
            }

            if ($value instanceof AbstractModel) {
                /** @noinspection PhpUnhandledExceptionInspection */
                $value->validateFields();
            }
        } elseif (gettype($value) !== $expectedType && ($expectedType !== 'float' || !in_array(gettype($value), ['integer', 'double'], true))) {
            throw new InvalidFieldValueException($typeErrorMessage);
        }
    }

    private static function mapType(string $type): string
    {
        return match ($type) {
            'int' => 'integer',
            'bool' => 'boolean',
            default => $type,
        };
    }

    /**
     * @throws InvalidFieldValueException
     */
    private static function additionalFieldValidation(AbstractModel $model, string $propertyName, mixed $value): void
    {
        $modelReflection = ReflectionHelper::getModelApiFields($model, true);
        if (!is_array($modelReflection[$propertyName] ?? null)) {
            return;
        }

        [, , $validations] = $modelReflection[$propertyName];

        foreach ($validations->getValidations() as $validation) {
            match (true) {
                $validation instanceof StringLength => self::validateStringLength($validation, $value),
                $validation instanceof Enum => self::validateEnum($validation, $value),
                default => null,
            };
        }
    }

    private static function validateStringLength(StringLength $validation, mixed $value): void
    {
        if ($value === null) {
            // this should be already validated
            return;
        }

        if (!is_string($value)) {
            throw new InvalidFieldValueException('value needs to be a string');
        }

        if ($validation->getMinLength() !== null && strlen($value) < $validation->getMinLength()) {
            throw new InvalidFieldValueException($validation->getValidationMessage() ?: sprintf('value needs to be at least %s characters.', $validation->getMinLength()));
        }

        if ($validation->getMaxLength() !== null && strlen($value) > $validation->getMaxLength()) {
            throw new InvalidFieldValueException($validation->getValidationMessage() ?: sprintf('value needs to be at most %s characters.', $validation->getMaxLength()));
        }
    }

    private static function validateEnum(Enum $validation, mixed $value): void
    {
        if ($value === null) {
            // this should be already validated
            return;
        }

        if (!in_array($value, $validation->getValidValues(), true)) {
            $message = $validation->getValidationMessage() ?:
                sprintf(
                    'Value must be on of: %s. Given: %s',
                    implode(',', $validation->getValidValues()),
                    print_r($value, true)
                );

            throw new InvalidFieldValueException($message);
        }
    }
}
