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

class DuplicateFacilityException extends GatewayException
{
    protected function getErrorMessage(): string
    {
        return 'The buyer does already have an active facility';
    }
}
