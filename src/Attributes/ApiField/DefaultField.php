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
use ReflectionProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DefaultField
{
    public function __construct(
        private readonly ?string $apiField = null
    ) {
    }

    public function getApiField(ReflectionProperty $property): ?string
    {
        return $this->apiField ?: strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $property->getName()));
    }
}
