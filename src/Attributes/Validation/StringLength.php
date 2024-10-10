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
class StringLength implements ValidationInterface
{
    public function __construct(
        private readonly ?int $minLength = null,
        private readonly ?int $maxLength = null,
        private readonly ?string $validationMessage = null
    ) {
    }

    public function getValidationMessage(): ?string
    {
        return $this->validationMessage;
    }

    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }
}
