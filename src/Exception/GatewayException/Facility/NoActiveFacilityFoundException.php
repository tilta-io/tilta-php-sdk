<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException\Facility;

use Tilta\Sdk\Exception\GatewayException\NotFoundException;

class NoActiveFacilityFoundException extends NotFoundException
{
    public function __construct(string $buyerExternalId, int $httpCode = 404, array $responseData = [], array $requestData = [])
    {
        parent::__construct($buyerExternalId, $httpCode, $responseData, $requestData);
    }

    protected function getErrorMessage(): string
    {
        return 'The buyer does not have an active facility';
    }
}
