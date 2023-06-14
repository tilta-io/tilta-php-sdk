<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception;

use Exception;
use Throwable;

class TiltaException extends Exception
{
    protected string $tiltaCode;

    public function __construct(string $message = '', string $code = 'ERROR', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->tiltaCode = $code;
    }

    public function getTiltaCode(): string
    {
        return $this->tiltaCode;
    }
}
