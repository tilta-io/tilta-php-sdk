<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Enum;

final class PaymentTermEnum
{
    /**
     * @var string
     */
    public const PREPAYMENT = 'PREPAYMENT';

    /**
     * @var string
     */
    public const BNPL7 = 'BNPL7';

    /**
     * @var string
     */
    public const BNPL14 = 'BNPL14';

    /**
     * @var string
     */
    public const BNPL30 = 'BNPL30';

    /**
     * @var string
     */
    public const BNPL45 = 'BNPL45';

    /**
     * @var string
     */
    public const BNPL60 = 'BNPL60';

    /**
     * @var string
     */
    public const BNPL90 = 'BNPL90';
}
