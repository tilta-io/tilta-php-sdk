<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use DateTime;
use InvalidArgumentException;
use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @internal
 */
class ResponseHelper
{
    /**
     * @return ($nullable is true ? mixed|null : mixed)
     */
    public static function getValue(array $data, string $key, bool $nullable = true)
    {
        return $data[$key] ?? self::throwIfNotNullable($data, $key, $nullable);
    }

    /**
     * @return ($nullable is true ? string|null : string)
     */
    public static function getString(array $data, string $key, bool $nullable = true): ?string
    {
        $value = self::getValue($data, $key, $nullable);

        return is_string($value) || is_numeric($value) ? (string) $value : self::throwIfNotNullable($data, $key, $nullable);
    }

    /**
     * @return ($nullable is true ? int|null : int)
     */
    public static function getInt(array $data, string $key, bool $nullable = true): ?int
    {
        $value = self::getValue($data, $key, $nullable);

        return is_numeric($value) ? (int) $value : self::throwIfNotNullable($data, $key, $nullable);
    }

    /**
     * @return ($nullable is true ? float|null : float)
     */
    public static function getFloat(array $data, string $key, bool $nullable = true): ?float
    {
        $value = self::getValue($data, $key, $nullable);

        return is_numeric($value) ? (float) $value : self::throwIfNotNullable($data, $key, $nullable);
    }

    public static function getBoolean(array $data, string $key): ?bool
    {
        $value = self::getValue($data, $key, true);

        if (is_numeric($value)) {
            return (int) $value === 1;
        }

        if (is_bool($value)) {
            return $value;
        }

        return false;
    }

    /**
     * @return ($nullable is true ? array|null : array)
     */
    public static function getArray(array $data, string $key, string $itemClass = null, bool $itemReadOnly = true, bool $nullable = true): ?array
    {
        if ($itemClass !== null && !is_subclass_of($itemClass, AbstractModel::class)) {
            throw new InvalidArgumentException('argument `$itemClass` needs to be a subclass of ' . AbstractModel::class);
        }

        $value = self::getValue($data, $key, $nullable);

        $values = is_array($value) ? $value : null;
        if ($values !== null && $itemClass !== null) {
            foreach ($values as $i => $e) {
                $values[$i] = new $itemClass($e, $itemReadOnly);
            }
        }

        return $values;
    }

    /**
     * @return ($nullable is true ? DateTime|null : DateTime)
     */
    public static function getDateTime(array $data, string $key, string $format = 'Y-m-d H:i:s', bool $nullable = true): ?DateTime
    {
        $value = self::getString($data, $key, $nullable);
        // added `!` to set time of object to midnight if no time-format is given
        $return = $value ? DateTime::createFromFormat('!' . $format, $value) : null;

        return $return ?: self::throwIfNotNullable($data, $key, $nullable);
    }

    /**
     * @return ($nullable is true ? DateTime|null : DateTime)
     */
    public static function getDate(array $data, string $key, string $format = 'Y-m-d', bool $nullable = true): ?DateTime
    {
        return self::getDateTime($data, $key, $format, $nullable);
    }

    /**
     * @template T
     * @param class-string<T> $class the class to instantiate
     * @return ($nullable is true ? T|null : T)
     */
    public static function getObject(array $data, string $key, string $class, bool $readOnly = true, bool $createEmptyObjectOnNull = false, bool $nullable = true)
    {
        if ($class === DateTime::class) {
            /** @phpstan-ignore-next-line */
            return self::getDateTime($data, $key, 'U', $nullable); // U = default of gateway response
        }

        $value = self::getValue($data, $key, true);

        if (!is_subclass_of($class, AbstractModel::class)) {
            throw new InvalidArgumentException('argument `$class` needs to be a subclass of ' . AbstractModel::class);
        }

        $instance = new $class([], $readOnly);
        if (is_array($value)) {
            if ($value !== ['___PHPUNIT___']) {
                $instance->fromArray($value);
            }

            return $instance;
        } elseif ($createEmptyObjectOnNull) {
            return $instance;
        }

        return self::throwIfNotNullable($data, $key, $nullable);
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
