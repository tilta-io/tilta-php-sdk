<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\Validation;

use Tilta\Sdk\Exception\TiltaException;

class InvalidFieldValueException extends TiltaException
{
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
