<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model;

use Jasny\PhpdocParser\PhpdocParser;
use Jasny\PhpdocParser\Set\PhpDocumentor;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tilta\Sdk\Model\AbstractModel;

class ModelCorrectAnnotationTest extends TestCase
{
    /**
     * @dataProvider dataProviderMethods
     * @param class-string $class
     */
    public function testIfAllGettersSettersHaveTheCorrectDeclaration(string $class, string $methodName, array $config): void
    {
        $classReflection = (new ReflectionClass($class));

        preg_match('/^(get|set)(.*)/', $methodName, $matches);

        $propertyName = lcfirst($matches[2]);
        static::assertTrue($classReflection->hasProperty($propertyName), sprintf('property %s::%s should exist', $class, $propertyName));
        static::assertTrue($classReflection->getProperty($propertyName)->isProtected(), sprintf('property %s::%s should be protected', $class, $propertyName));
        if ($matches[1] === 'set') {
            static::assertCount(1, $config['params'], sprintf('defined method %s::%s should have a argument to set the value', $class, $methodName));
            static::assertArrayHasKey($propertyName, $config['params'], sprintf('defined method %s::%s should have a argument with the name %s', $class, $methodName, $propertyName));
            static::assertEquals('$this', $config['return_type'], sprintf('defined method %s::%s should return $this', $class, $methodName));
        } elseif ($matches[1] === 'get') {
            static::assertCount(0, $config['params'], sprintf('defined method %s::%s should not have any arguments', $class, $methodName));
        }
    }

    /**
     * @dataProvider dataProviderClasses
     */
    public function testIfAllClassesAreInstanceOfAbstractModel(string $class): void
    {
        static::assertTrue(is_subclass_of($class, AbstractModel::class), sprintf('%s should be a subcloss of %s', $class, AbstractModel::class));
    }

    public function dataProviderClasses(): array
    {
        return array_map(static fn ($class): array => [$class], $this->getModelClasses());
    }

    public function dataProviderMethods(): array
    {
        $data = [];
        foreach ($this->getModelClasses() as $class) {
            $data = [
                ...$data,
                ...array_map(static fn (array $methodConfig): array => [
                    $class,
                    $methodConfig['name'],
                    $methodConfig,
                ], array_values($this->getMethodMetaData($class))),
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

    /**
     * @param class-string $class
     */
    private function getMethodMetaData(string $class): array
    {
        $reflectionClass = new ReflectionClass($class);
        if (!$reflectionClass->getDocComment()) {
            return [];
        }

        $doc = $reflectionClass->getDocComment();

        $parser = new PhpdocParser(PhpDocumentor::tags());
        $meta = $parser->parse($doc);

        return array_filter(
            $meta['methods'] ?? [],
            static fn ($methodName) => preg_match('/^(get|set)(.*)/', $methodName),
            ARRAY_FILTER_USE_KEY
        );
    }
}
