<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use BadMethodCallException;
use DateTimeInterface;
use ReflectionProperty;
use ReflectionType;
use Tilta\Sdk\Exception\TiltaException;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Util\ReflectionHelper;
use Tilta\Sdk\Util\ResponseHelper;
use Tilta\Sdk\Util\Validation;

abstract class AbstractModel
{
    private bool $_validateOnSet = true;

    private bool $_modelHasBeenValidated = false;

    public function __construct(
        array $data = [],
        private readonly bool $_readOnly = false
    ) {
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

        if (str_starts_with($name, 'set') && method_exists($this, 'set')) {
            return $this->set($field, $arguments[0] ?? null);
        }

        if (str_starts_with($name, 'get') || str_starts_with($name, 'is')) {
            return $this->get($field);
        }

        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . static::class . '`');
    }

    /**
     * @return $this
     * @internal
     */
    public function fromArray(array $data): self
    {
        foreach (ReflectionHelper::getModelApiFields(static::class) as $definition) {
            [$property, $fieldType] = $definition;

            $this->{$property->getName()} = ResponseHelper::getValue($data, $property, $fieldType);
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
        foreach (ReflectionHelper::getModelApiFields(static::class) as $definition) {
            [$property] = $definition;
            try {
                $this->validateFieldValue($property->getName(), $this->get($property->getName()));
            } catch (InvalidFieldValueException $invalidFieldValueException) {
                $errorCollection->addError($property->getName(), $invalidFieldValueException);
            }
        }

        if ($errorCollection->getErrors() !== []) {
            throw $errorCollection;
        }

        $this->_modelHasBeenValidated = true;
    }

    /**
     * @return $this
     */
    public function enableValidateOnSet(): self
    {
        return $this->setValidateOnSet(true);
    }

    /**
     * @return $this
     */
    public function disableValidateOnSet(): self
    {
        return $this->setValidateOnSet(false);
    }

    /**
     * @return $this
     */
    public function setValidateOnSet(bool $flag): self
    {
        $this->_validateOnSet = $flag;

        return $this;
    }

    /**
     * @deprecated
     */
    protected function prepareModelData(array $data): array
    {
        return [];
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    protected function _toArray(): array
    {
        $values = [];

        foreach (ReflectionHelper::getModelApiFields(static::class) as $definition) {
            [$property, $field] = $definition;
            if ($property->isInitialized($this)) {
                $values[$field->getApiField($property)] = $this->convertObjectsRecursively($this->get($property->getName()));
            }
        }

        return $values;
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    private function convertObjectsRecursively(mixed $value): mixed
    {
        if ($value instanceof self) {
            return $value->toArray();
        } elseif ($value instanceof DateTimeInterface) {
            return $value->getTimestamp();
        } elseif (is_array($value)) {
            foreach ($value as $key => $_value) {
                $value[$key] = $this->convertObjectsRecursively($_value);
            }
        }

        return $value;
    }

    /**
     * @throws InvalidFieldException
     */
    private function get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->{$name} ?? null;
        }

        throw new InvalidFieldException($name, $this);
    }

    /**
     * @throws TiltaException
     */
    private function set(string $name, mixed $value): self
    {
        if ($this->_readOnly) {
            throw new BadMethodCallException('the model `' . static::class . '` is read only');
        }

        if (property_exists($this, $name)) {
            if ($this->_validateOnSet) {
                try {
                    $this->validateFieldValue($name, $value);
                } catch (InvalidFieldException) {
                    // ignore this error. if the field does not exist, it is allowed to set the value.
                    // It will throw a fatal error if it is the wrong data-type.
                }
            } else {
                $this->_modelHasBeenValidated = false;
            }

            // special case: if the property does not allow null, but the validation definition allows null, we will unset the property.
            if ($value === null) {
                $propertyType = (new ReflectionProperty($this, $name))->getType();
                if ($propertyType instanceof ReflectionType && !$propertyType->allowsNull()) {
                    unset($this->{$name});

                    return $this;
                }
            }

            $this->{$name} = $value;

            return $this;
        }

        throw new InvalidFieldException($name, $this);
    }

    /**
     * @throws InvalidFieldValueException
     * @throws InvalidFieldException
     */
    private function validateFieldValue(string $fieldName, mixed $value): void
    {
        Validation::validatePropertyValue($this, $fieldName, $value);
    }
}
