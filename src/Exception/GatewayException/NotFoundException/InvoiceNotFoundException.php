<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException\NotFoundException;

use Tilta\Sdk\Exception\GatewayException\NotFoundException;

class InvoiceNotFoundException extends NotFoundException
{
    protected static ?string $entityName = 'Invoice';

    public function getTiltaCode(): string
    {
        return 'INVOICE_NOT_FOUND';
    }
}
