<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException\NotFoundException;

use Tilta\Sdk\Exception\GatewayException\EntityNotFoundException;

class MerchantNotFoundException extends EntityNotFoundException
{
    protected static ?string $entityName = 'Merchant';

    public function getTiltaCode(): string
    {
        return 'MERCHANT_NOT_FOUND';
    }
}
