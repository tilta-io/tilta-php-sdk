<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException;

use Tilta\Sdk\Exception\GatewayException;

class InvalidRequestException extends GatewayException
{
    public function getTiltaCode(): string
    {
        return 'INVALID_REQUEST';
    }
}
