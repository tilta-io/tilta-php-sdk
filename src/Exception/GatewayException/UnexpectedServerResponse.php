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

class UnexpectedServerResponse extends GatewayException
{
    protected static ?string $defaultErrorMessage = 'Unknown gateway response';

    protected static string $defaultErrorCode = 'UNKNOWN_GATEWAY_EXCEPTION';
}
