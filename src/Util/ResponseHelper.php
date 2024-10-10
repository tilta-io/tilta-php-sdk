<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use DateTime;
use DateTimeInterface;
use InvalidArgumentException;
use LogicException;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;
use Tilta\Sdk\Attributes\ApiField\DateTimeField;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Attributes\ApiField\ObjectField;
use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @internal
 */
class ResponseHelper
{
    /**
     * @internal
     * @var string[]
     */
    public const PHPUNIT_OBJECT = ['___PHPUNIT___'];

    public static function getValue(array $data, ReflectionProperty $property, DefaultField $definition): mixed
    {
        if (!$property->getType() instanceof ReflectionNamedType) {
            throw new RuntimeException('unknown property type');
        }

        $isNullable = $property->getType()->allowsNull();
        $type = $property->getType()->getName();

        $rawValue = $data[$definition->getApiField($property)] ?? null;

        if (class_exists($type) || interface_exists($type)) { // interface: date-time
            // TODO implement little backdoor or unit-tests, that objects can be empty.
            $value = self::getObject($rawValue, $type, $definition);
        } elseif ($type === 'array') {
            $value = self::getArray($rawValue, $definition);
        } else {
            $value = match ($type) {
                'int' => self::getInt($rawValue),
                'float' => self::getFloat($rawValue),
                'bool', 'boolean' => self::getBoolean($rawValue),
                'string' => self::getString($rawValue),
                default => null,
            };
        }

        return $value ?? self::throwIfNotNullable($data, $property->getName(), $isNullable);
    }

    private static function getString(mixed $rawData): ?string
    {
        return is_string($rawData) || is_numeric($rawData) ? (string) $rawData : null;
    }

    private static function getInt(mixed $rawData): ?int
    {
        return is_numeric($rawData) ? (int) $rawData : null;
    }

    private static function getFloat(mixed $rawData): ?float
    {
        return is_numeric($rawData) ? (float) $rawData : null;
    }

    private static function getBoolean(mixed $rawData): ?bool
    {
        if (is_numeric($rawData)) {
            return (int) $rawData === 1;
        }

        if (is_bool($rawData)) {
            return $rawData;
        }

        return $rawData !== null ? false : null;
    }

    private static function getArray(mixed $rawValue, DefaultField $definition, bool $itemReadOnly = true): ?array
    {
        $itemClass = $definition instanceof ListField ? $definition->getExpectedItemClass() : null;

        $values = is_array($rawValue) ? $rawValue : null;
        if ($itemClass === null) {
            return $values;
        }

        if ($values !== null) {
            if (!is_subclass_of($itemClass, AbstractModel::class)) {
                throw new LogicException('invalid expected item class');
            }

            foreach ($values as $i => $e) {
                $values[$i] = new $itemClass([], $itemReadOnly);
                if ($e !== self::PHPUNIT_OBJECT) {
                    $values[$i]->fromArray($e);
                }
            }
        }

        return $values;
    }

    private static function getDateTime(mixed $rawData, DefaultField $fieldDefinition): ?DateTimeInterface
    {
        $format = $fieldDefinition instanceof DateTimeField ? $fieldDefinition->getFormat() : DateTimeField::DEFAULT_FORMAT;

        $value = self::getString($rawData);

        // add `!` to set time of object to midnight if no time-format is given
        $format = str_starts_with($format, '!') ? $format : '!' . $format;

        return $value ? DateTime::createFromFormat($format, $value) ?: null : null;
    }

    /**
     * @template T
     * @param class-string<T> $class the class to instantiate
     */
    private static function getObject(mixed $rawData, string $class, DefaultField $fieldDefinition): ?object
    {
        if ($class === DateTimeInterface::class || $class === DateTime::class) {
            /** @phpstan-ignore-next-line */
            return self::getDateTime($rawData, $fieldDefinition);
        }

        if (!is_subclass_of($class, AbstractModel::class)) {
            throw new InvalidArgumentException('argument `$class` needs to be a subclass of ' . AbstractModel::class);
        }

        $isReadonly = $fieldDefinition instanceof ObjectField ? $fieldDefinition->isResponseIsReadOnly() : true;
        $instance = new $class([], $isReadonly);
        if (is_array($rawData)) {
            if ($rawData !== self::PHPUNIT_OBJECT) {
                $instance->fromArray($rawData);
            }

            return $instance;
        }

        return null;
    }

    /**
     * @phpstan-ignore-next-line
     */
    private static function throwIfNotNullable(array $data, string $key, bool $nullable)
    {
        if (!$nullable) {
            throw new InvalidResponseException(
                sprintf(
                    'Key `%s` was expected in response. key does not exist, or is null. Object: %s',
                    $key,
                    (string) json_encode($data)
                )
            );
        }

        return null;
    }
}
