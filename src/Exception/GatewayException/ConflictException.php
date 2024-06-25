<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException;

use Tilta\Sdk\Exception\GatewayException;

class ConflictException extends GatewayException
{
    protected static ?string $defaultErrorMessage = 'The entity does already exist.';

    protected static string $defaultErrorCode = 'CONFLICT';
}
