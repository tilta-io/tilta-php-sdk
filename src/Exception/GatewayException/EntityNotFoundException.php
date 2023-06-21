<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException;

abstract class EntityNotFoundException extends NotFoundException
{
    final public function __construct(string $externalId, int $httpCode = 404, array $responseData = [], array $requestData = [])
    {
        parent::__construct($externalId, $httpCode, $responseData, $requestData);
    }
}
