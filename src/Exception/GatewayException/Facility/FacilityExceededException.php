<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException\Facility;

use Tilta\Sdk\Exception\GatewayException;

class FacilityExceededException extends GatewayException
{
    public function __construct(string $buyerExternalId, int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct($httpCode, $responseData, $requestData);
        $this->message = sprintf('The facility amount for buyer with external id `%s` is exceeded', $buyerExternalId);
    }

    public function getTiltaCode(): string
    {
        return 'FACILITY_EXCEEDED_AVAILABLE_AMOUNT';
    }
}
