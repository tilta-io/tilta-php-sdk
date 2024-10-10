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
class DateTimeField extends DefaultField
{
    public const DEFAULT_FORMAT = 'U';

    public function __construct(
        ?string $apiField = null,
        private readonly string $format = self::DEFAULT_FORMAT
    ) {
        parent::__construct($apiField);
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
