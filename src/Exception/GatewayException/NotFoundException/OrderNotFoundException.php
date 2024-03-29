<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException\NotFoundException;

use Tilta\Sdk\Exception\GatewayException\NotFoundException;

class OrderNotFoundException extends NotFoundException
{
    protected static ?string $entityName = 'Order';

    public function getTiltaCode(): string
    {
        return 'ORDER_NOT_FOUND';
    }
}
