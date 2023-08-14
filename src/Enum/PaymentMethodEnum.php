<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Enum;

final class PaymentMethodEnum
{
    /**
     * @var string
     */
    public const CASH = 'CASH';

    /**
     * @var string
     */
    public const CARD = 'CARD';

    /**
     * @var string
     */
    public const TRANSFER = 'TRANSFER';

    /**
     * @var string
     */
    public const BNPL = 'BNPL30';
}
