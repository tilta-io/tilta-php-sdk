<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use ReflectionException;
use ReflectionProperty;
use ReflectionType;
use RuntimeException;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\AbstractModel;

class Validation
{
    /**
     * @var string
     */
    public const TYPE_STRING_REQUIRED = 'string';

    /**
     * @var string
     */
    public const TYPE_STRING_OPTIONAL = '?' . self::TYPE_STRING_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_INT_REQUIRED = 'integer';

    /**
     * @var string
     */
    public const TYPE_INT_OPTIONAL = '?' . self::TYPE_INT_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_FLOAT_REQUIRED = 'float';

    /**
     * @var string
     */
    public const TYPE_FLOAT_OPTIONAL = '?' . self::TYPE_FLOAT_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_BOOLEAN_REQUIRED = 'boolean';

    /**
     * @var string
     */
    public const TYPE_BOOLEAN_OPTIONAL = '?' . self::TYPE_BOOLEAN_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_ARRAY_REQUIRED = 'array';

    /**
     * @var string
     */
    public const TYPE_ARRAY_OPTIONAL = '?' . self::TYPE_ARRAY_REQUIRED;

    /**
     * @var string
     */
    public const IS_REQUIRED = '_is_required';

    /**
     * @var string
     */
    public const IS_NOT_REQUIRED = '_is_not_required';

    /**
     * @param mixed $value
     * @param string|callable|null $customDefinedType
     * @throws InvalidFieldException
     * @throws InvalidFieldValueException
     */
    public static function validatePropertyValue(AbstractModel $model, string $propertyName, $value, $customDefinedType = null): void
    {
        if (is_callable($customDefinedType)) {
            $customDefinedType = $customDefinedType($model, $value);
        }

        if ($customDefinedType !== null && !is_string($customDefinedType)) {
            throw new RuntimeException(sprintf('Custom validation for %s::%s needs to be a callable (which returns a string) or a string. Given: %s', get_class($model), $propertyName, is_object($value) ? get_class($value) : gettype($value)));
        }

        try {
            self::validateByReflection($model, $propertyName, $value, $customDefinedType);
            if ($customDefinedType !== null) {
                self::validateByCustomDefinition($value, $customDefinedType);
            }
        } catch (InvalidFieldValueException $invalidFieldValueException) {
            $invalidFieldValueException->setMessage(
                sprintf('The field %s::%s has an invalid value. ', get_class($model), $propertyName) .
                $invalidFieldValueException->getMessage()
            );
            throw $invalidFieldValueException;
        }
    }

    /**
     * @param mixed $value
     * @throws InvalidFieldException
     * @throws InvalidFieldValueException
     */
    private static function validateByReflection(AbstractModel $model, string $property, $value, string $customDefinedType = null): void
    {
        try {
            $reflectionProperty = new ReflectionProperty(get_class($model), $property);
        } catch (ReflectionException $reflectionException) {
            throw new InvalidFieldException($property, $model);
        }

        $reflectionType = $reflectionProperty->getType();
        // method_exist: also see: https://github.com/phpstan/phpstan/issues/1133
        if (!$reflectionType instanceof ReflectionType || !method_exists($reflectionType, 'getName')) {
            return;
        }

        $reflectionTypeName = $reflectionType->getName();

        if ($value === null) {
            if ((!$reflectionType->allowsNull() && $customDefinedType !== self::IS_NOT_REQUIRED) || $customDefinedType === self::IS_REQUIRED) {
                throw new InvalidFieldValueException(
                    sprintf('The property %s::%s does not accept a null-value.', get_class($model), $property)
                );
            }

            return;
        }

        if ($reflectionTypeName === 'array') {
            self::validateSimpleValue('array', $value);

            if (is_array($value) && $customDefinedType !== null && preg_match('/\[]$/', $customDefinedType)) {
                $customDefinedType = (string) preg_replace('/\[]$/', '', $customDefinedType);
                foreach ($value as $_value) {
                    self::validateSimpleValue($customDefinedType, $_value);
                }
            }
        } else {
            self::validateSimpleValue($reflectionTypeName, $value);
        }
    }

    /**
     * @param mixed $value
     * @throws InvalidFieldValueException
     */
    private static function validateByCustomDefinition($value, string $customDefinedType): void
    {
        if (in_array($customDefinedType, [self::IS_REQUIRED, self::IS_NOT_REQUIRED], true)) {
            // these types are only relevant for fields, which got processed by reflection validation.
            // the model can define custom validation for fields with one of these "types" to override the "is (not) null" validation
            return;
        }

        if (preg_match('/(\??)(.*)\[]/', $customDefinedType, $matches)) {
            self::validateSimpleValue($matches[1] . 'array', $value);
            if (is_array($value)) {
                foreach ($value as $_value) {
                    self::validateSimpleValue($matches[2], $_value);
                }
            }
        } else {
            self::validateSimpleValue($customDefinedType, $value);
        }
    }

    /**
     * @param mixed $value
     */
    private static function getErrorMessage(string $expectedType, $value): string
    {
        return sprintf('Expected type: %s. Given type: %s', $expectedType, is_object($value) ? get_class($value) : gettype($value));
    }

    /**
     * @param mixed $value
     * @throws InvalidFieldValueException
     * @noinspection PhpDocMissingThrowsInspection
     */
    private static function validateSimpleValue(string $expectedType, $value): void
    {
        if (strpos($expectedType, '?') === 0) {
            $expectedType = substr($expectedType, 1);
            if ($value === null) {
                return;
            }
        }

        $typeErrorMessage = self::getErrorMessage($expectedType, $value);

        $expectedType = self::mapType($expectedType);

        if (class_exists($expectedType)) {
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
        switch ($type) {
            case 'int':
                return 'integer';
            case 'bool':
                return 'boolean';
            default:
                return $type;
        }
    }
}
