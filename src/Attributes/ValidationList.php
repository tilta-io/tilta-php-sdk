<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Attributes;

use Tilta\Sdk\Attributes\Validation\ValidationInterface;

class ValidationList
{
    /**
     * @param ValidationInterface[] $validations
     */
    public function __construct(
        private readonly array $validations
    ) {
    }

    public function hasValidation(string $attributeClass): bool
    {
        return isset($this->validations[$attributeClass]);
    }

    /**
     * @template T of ValidationInterface
     * @param class-string<T> $attributeClass
     * @return T|null
     */
    public function getValidation(string $attributeClass): ?ValidationInterface
    {
        $instance = $this->validations[$attributeClass] ?? null;

        return $instance instanceof $attributeClass ? $instance : null;
    }

    /**
     * @return ValidationInterface[]
     */
    public function getValidations(): array
    {
        return $this->validations;
    }
}
