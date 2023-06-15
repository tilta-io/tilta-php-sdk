<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use BadMethodCallException;
use DateTime;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use Tilta\Sdk\Exception\TiltaException;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Util\ResponseHelper;
use Tilta\Sdk\Util\Validation;

abstract class AbstractModel
{
    /**
     * maps the model-field to the gateway-field
     * @var array<string, string>
     */
    protected static array $_additionalFieldMapping = [];

    private bool $_readOnly = false;

    private bool $_validateOnSet = true;

    private bool $_modelHasBeenValidated = false;

    public function __construct(array $data = [], bool $readOnly = false)
    {
        $this->_readOnly = $readOnly;
        if ($data !== []) {
            $this->fromArray($data);
        }
    }

    /**
     * @return mixed|null
     */
    public function __call(string $name, ?array $arguments = [])
    {
        $field = lcfirst(substr($name, 3));

        if (strpos($name, 'set') === 0 && method_exists($this, 'set')) {
            return $this->set($field, $arguments[0] ?? null);
        }

        if (strpos($name, 'get') === 0 || strpos($name, 'is') === 0) {
            return $this->get($field);
        }

        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . self::class . '`');
    }

    /**
     * @internal
     */
    public function fromArray(array $data): self
    {
        $customMappings = $this->prepareModelData($data);

        $ref = new ReflectionClass($this);
        foreach ($this->getPropertyNames() as $propertyName) {
            $dataKey = static::$_additionalFieldMapping[$propertyName] ?? $this->convertPropertyNameToSnakeCase($propertyName);

            /** @noinspection PhpUnhandledExceptionInspection */
            $property = $ref->getProperty($propertyName);
            $refType = $property->getType();
            if (!$refType instanceof ReflectionNamedType) {
                continue;
            }

            $isNullable = $refType->allowsNull();
            $type = $refType->getName();
            if (!is_callable($customMappings[$propertyName] ?? null)) {
                if (class_exists($type)) {
                    $value = $isNullable ? ResponseHelper::getObject($data, $dataKey, $type) : ResponseHelper::getObjectNN($data, $dataKey, $type);
                } else {
                    switch ($type) {
                        case 'int':
                            $value = $isNullable ? ResponseHelper::getInt($data, $dataKey) : ResponseHelper::getIntNN($data, $dataKey);
                            break;
                        case 'float':
                            $value = $isNullable ? ResponseHelper::getFloat($data, $dataKey) : ResponseHelper::getFloatNN($data, $dataKey);
                            break;
                        case 'bool':
                        case 'boolean':
                            $value = ResponseHelper::getBoolean($data, $dataKey);
                            break;
                        case 'string':
                            $value = $isNullable ? ResponseHelper::getString($data, $dataKey) : ResponseHelper::getStringNN($data, $dataKey);
                            break;
                        case 'array':
                            $value = ResponseHelper::getArray($data, $dataKey) ?? [];
                            break;
                    }
                }
            } else {
                $value = $customMappings[$propertyName]($dataKey);
            }

            if (!isset($value) && $isNullable) {
                $value = null;
            }

            if (isset($value)) {
                $this->{$propertyName} = $value;
                unset($value);
            }
        }

        return $this;
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    public function toArray(): array
    {
        // we can not mark this method as final, because we can not use the models for mocks in phpunit when it is final.
        $this->validateFields();

        return $this->_toArray();
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    public function validateFields(): void
    {
        if ($this->_modelHasBeenValidated) {
            // model values has not been changed and the last check was valid.
            return;
        }

        $errorCollection = new InvalidFieldValueCollectionException();
        foreach ($this->getObjectVars() as $field => $value) {
            try {
                $this->validateFieldValue($field, $value);
            } catch (InvalidFieldValueException $invalidFieldValueException) {
                $errorCollection->addError($field, $invalidFieldValueException);
            }
        }

        if ($errorCollection->getErrors() !== []) {
            throw $errorCollection;
        }

        $this->_modelHasBeenValidated = true;
    }

    public function enableValidateOnSet(): self
    {
        return $this->setValidateOnSet(true);
    }

    public function disableValidateOnSet(): self
    {
        return $this->setValidateOnSet(false);
    }

    public function setValidateOnSet(bool $flag): self
    {
        $this->_validateOnSet = $flag;

        return $this;
    }

    protected function prepareModelData(array $data): array
    {
        return [];
    }

    protected function getFieldValidations(): array
    {
        return [];
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    protected function _toArray(): array
    {
        $preparedData = $this->prepareValuesForGateway($this->getObjectVars());

        $values = [];
        foreach ($preparedData as $key => $value) {
            $key = static::$_additionalFieldMapping[$key] ?? $key;
            $values[$this->convertPropertyNameToSnakeCase($key)] = $this->convertObjectsRecursively($value);
        }

        return $values;
    }

    protected function prepareValuesForGateway(array $data): array
    {
        return $data;
    }

    /**
     * @param mixed $value
     * @return mixed
     * @throws InvalidFieldValueCollectionException
     */
    private function convertObjectsRecursively($value)
    {
        if ($value instanceof self) {
            return $value->toArray();
        } elseif ($value instanceof DateTime) {
            return $value->getTimestamp();
        } elseif (is_array($value)) {
            foreach ($value as $key => $_value) {
                $value[$key] = $this->convertObjectsRecursively($_value);
            }
        }

        return $value;
    }

    private function getPropertyNames(): array
    {
        $names = [];
        $refModel = new ReflectionClass($this);
        $refSelf = new ReflectionClass(self::class); // not $this/static::class!
        foreach ($refModel->getProperties(ReflectionProperty::IS_PROTECTED) as $property) {
            if (!$refSelf->hasProperty($property->getName())) {
                $names[] = $property->getName();
            }
        }

        // filter properties which seems to be they should not send to gateway
        return array_filter($names, static fn (string $key): bool => strpos($key, '_') !== 0);
    }

    private function getObjectVars(): array
    {
        $vars = [];
        foreach ($this->getPropertyNames() as $propertyName) {
            $vars[$propertyName] = $this->{$propertyName} ?? null;
        }

        return $vars;
    }

    private function convertPropertyNameToSnakeCase(string $string): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    /**
     * @return mixed|null
     * @throws InvalidFieldException
     */
    private function get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name} ?? null;
        }

        throw new InvalidFieldException($name, $this);
    }

    /**
     * @param mixed|null $value
     * @throws TiltaException
     */
    private function set(string $name, $value): self
    {
        if ($this->_readOnly) {
            throw new BadMethodCallException('the model `' . static::class . '` is read only');
        }

        if (property_exists($this, $name)) {
            if ($this->_validateOnSet) {
                $this->validateFieldValue($name, $value);
            } else {
                $this->_modelHasBeenValidated = false;
            }

            $this->{$name} = $value;

            return $this;
        }

        throw new InvalidFieldException($name, $this);
    }

    /**
     * @param string $field the field-name to validate
     * @param mixed $value the value to validate
     * @throws InvalidFieldValueException
     */
    private function validateFieldValue(string $field, $value): void
    {
        $validations = $this->getFieldValidations();
        Validation::validatePropertyValue($this, $field, $value, $validations[$field] ?? null);
    }
}
