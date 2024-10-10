<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use Tilta\Sdk\Attributes\ApiField;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\Validation\ValidationInterface;
use Tilta\Sdk\Attributes\ValidationList;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @internal
 */
class ReflectionHelper
{
    /**
     * @var array<class-string, array<string, array{0: ReflectionProperty, 1: ApiField\DefaultField, 2?: ValidationList}>>
     */
    private static array $_reflectionPropertyCache = [];

    private static array $_reflectionValidationLoaded = [];

    /**
     * @param class-string|AbstractModel $modelOrClass
     * @return ($withValidation is true ? array<string, array{ReflectionProperty, ApiField\DefaultField, ValidationList}> : array<string, array{ReflectionProperty, ApiField\DefaultField, ?ValidationList}>)
     */
    public static function getModelApiFields(string|AbstractModel $modelOrClass, bool $withValidation = false): array
    {
        $className = is_string($modelOrClass) ? $modelOrClass : $modelOrClass::class;
        if (!isset(self::$_reflectionPropertyCache[$className])) {
            self::$_reflectionPropertyCache[$className] = [];

            $refModel = new ReflectionClass($modelOrClass);
            $refSelf = new ReflectionClass(AbstractModel::class); // not $this/self::class!
            foreach ($refModel->getProperties(ReflectionProperty::IS_PROTECTED) as $property) {
                if (!$refSelf->hasProperty($property->getName())) {
                    $fieldType = ($property->getAttributes(DefaultField::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null)
                        ?->newInstance();

                    if (!$fieldType instanceof DefaultField) {
                        continue;
                    }

                    self::$_reflectionPropertyCache[$className][$property->getName()] = [$property, $fieldType];
                }
            }
        }

        if ($withValidation) {
            self::mergeValidation($className);
        }

        /* @phpstan-ignore-next-line */
        return self::$_reflectionPropertyCache[$className];
    }

    private static function mergeValidation(string $className): void
    {
        if (!isset(self::$_reflectionValidationLoaded[$className])) {
            foreach (self::$_reflectionPropertyCache[$className] as &$field) {
                [$property] = $field;

                $validations = [];
                foreach ($property->getAttributes(ValidationInterface::class, ReflectionAttribute::IS_INSTANCEOF) as $validation) {
                    $validations[$validation->getName()] = $validation->newInstance();
                }

                $field[2] = new ValidationList($validations);
            }

            self::$_reflectionValidationLoaded[$className] = true;
        }
    }
}
