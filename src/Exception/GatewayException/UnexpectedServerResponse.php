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

class UnexpectedServerResponse extends GatewayException
{
    public function __construct(int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct(
            $responseData['message'] ?? 'Unknown gateway response',
            $httpCode,
            $responseData,
            $requestData
        );
    }

    public function getTiltaCode(): string
    {
        return 'UNKNOWN_GATEWAY_EXCEPTION';
    }
}
