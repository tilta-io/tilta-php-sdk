<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required implements ValidationInterface
{
    public function __construct(
        private readonly bool $required = true
    ) {
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getValidationMessage(): ?string
    {
        return null;
    }
}
