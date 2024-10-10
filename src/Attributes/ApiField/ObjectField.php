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

#[Attribute(Attribute::TARGET_PROPERTY)]
class ObjectField extends DefaultField
{
    public function __construct(
        ?string $apiField = null,
        private readonly bool $responseIsReadOnly = true
    ) {
        parent::__construct($apiField);
    }

    public function isResponseIsReadOnly(): bool
    {
        return $this->responseIsReadOnly;
    }
}
