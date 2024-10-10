<?php
/*
 * Copyright (c) WEBiDEA
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
    public function __construct(
        string $message = '',
        protected string $tiltaCode = 'ERROR',
        Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function getTiltaCode(): string
    {
        return $this->tiltaCode;
    }
}
