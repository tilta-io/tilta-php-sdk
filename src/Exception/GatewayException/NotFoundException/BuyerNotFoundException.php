<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException\NotFoundException;

use Tilta\Sdk\Exception\GatewayException\EntityNotFoundException;

class BuyerNotFoundException extends EntityNotFoundException
{
    protected static ?string $entityName = 'buyer';

    public function getTiltaCode(): string
    {
        return 'BUYER_NOT_FOUND';
    }
}
