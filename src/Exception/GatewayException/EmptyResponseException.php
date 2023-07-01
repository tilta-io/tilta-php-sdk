<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException;

use Tilta\Sdk\Exception\InvalidResponseException;

class EmptyResponseException extends InvalidResponseException
{
    public function __construct()
    {
        parent::__construct('No response was sent by the gateway but response was expected.');
    }
}
