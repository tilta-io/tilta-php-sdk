<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Attributes\ApiField;

use Attribute;
use InvalidArgumentException;
use Tilta\Sdk\Model\AbstractModel;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ListField extends DefaultField
{
    public function __construct(
        ?string $apiField = null,
        private readonly ?string $expectedItemClass = null,
        private readonly ?string $expectedScalarType = null,
        private readonly int $minCount = 0,
        private readonly int $maxCount = 0,
        private readonly bool $itemsReadonly = true,
    ) {
        if ($expectedItemClass !== null && !is_subclass_of($expectedItemClass, AbstractModel::class)) {
            throw new InvalidArgumentException('argument `$itemClass` needs to be a subclass of ' . AbstractModel::class);
        }

        parent::__construct($apiField);
    }

    public function getExpectedItemClass(): ?string
    {
        return $this->expectedItemClass;
    }

    public function getExpectedScalarType(): ?string
    {
        return $this->expectedScalarType;
    }

    public function getMinCount(): int
    {
        return $this->minCount;
    }

    public function getMaxCount(): int
    {
        return $this->maxCount;
    }

    public function isItemsReadonly(): bool
    {
        return $this->itemsReadonly;
    }
}
