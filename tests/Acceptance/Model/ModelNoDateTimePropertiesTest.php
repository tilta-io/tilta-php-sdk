<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model;

use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

class ModelNoDateTimePropertiesTest extends TestCase
{
    /**
     * @dataProvider dataProviderMethods
     * @param class-string $class
     */
    public function testIfDateTimePropertiesAreDeclaredWithDateTimeInterface(string $class, ReflectionProperty $property): void
    {
        $type = $property->getType();
        if ($type instanceof ReflectionNamedType) {
            static::assertNotTrue(is_subclass_of($type->getName(), DateTimeInterface::class), sprintf('Property %s::%s is type of %s. DateTime should be always only of type %s', $class, $property->getName(), $type->getName(), DateTimeInterface::class));
        }
    }

    public function dataProviderClasses(): array
    {
        return array_map(static fn ($class): array => [$class], $this->getModelClasses());
    }

    public function dataProviderMethods(): array
    {
        $data = [];
        foreach ($this->getModelClasses() as $class) {
            $properties = (new ReflectionClass($class))->getProperties();
            $properties = array_filter($properties, static fn (ReflectionProperty $property): bool => $property->class === $class && $property->isProtected() && strpos($property->getName(), '_') !== 0);

            $data = [
                ...$data,
                ...array_map(static fn (ReflectionProperty $property): array => [
                    $class,
                    $property,
                ], $properties),
            ];
        }

        return $data;
    }

    private function getModelClasses(): array
    {
        $basePath = __DIR__ . '/../../../src/';
        $files = [
            ...glob($basePath . 'Model/*.php') ?: [],
            ...glob($basePath . 'Model/**/*.php') ?: [],
            ...glob($basePath . 'Model/**/**/*.php') ?: [],
            ...glob($basePath . 'Model/**/**/**/*.php') ?: [],
            ...glob($basePath . 'Model/**/**/**/**/*.php') ?: [],
            ...glob($basePath . 'Model/**/**/**/**/**/*.php') ?: [],
        ];

        // matches files to class-names (without prefix)
        /** @var array $files */
        $files = preg_replace(['#' . $basePath . '#', '/\.php$/', '/\//'], ['', '', '\\'], $files);

        // add prefix-namespace
        $classList = array_map(static fn (string $class): string => 'Tilta\Sdk\\' . $class, $files);

        return array_filter($classList, static function (string $class): bool {
            if (!class_exists($class)) {
                return false;
            }

            $classReflection = (new ReflectionClass($class));

            return !$classReflection->isAbstract() && !$classReflection->isInterface();
        });
    }
}
