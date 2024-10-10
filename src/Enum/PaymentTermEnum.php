<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Enum;

enum PaymentTermEnum
{
    /**
     * @var string
     */
    public const PREPAYMENT = 'PREPAYMENT';

    /**
     * @var string
     * @deprecated
     */
    public const BNPL7 = self::DEFER7;

    /**
     * @var string
     * @deprecated
     */
    public const BNPL14 = self::DEFER14;

    /**
     * @var string
     * @deprecated
     */
    public const BNPL30 = self::DEFER30;

    /**
     * @var string
     * @deprecated
     */
    public const BNPL45 = self::DEFER45;

    /**
     * @var string
     * @deprecated
     */
    public const BNPL60 = self::DEFER60;

    /**
     * @var string
     * @deprecated
     */
    public const BNPL90 = self::DEFER90;

    /**
     * @var string
     */
    public const DEFER7 = 'DEFER_7D';

    /**
     * @var string
     */
    public const DEFER14 = 'DEFER_14D';

    /**
     * @var string
     */
    public const DEFER30 = 'DEFER_30D';

    /**
     * @var string
     */
    public const DEFER45 = 'DEFER_45D';

    /**
     * @var string
     */
    public const DEFER60 = 'DEFER_60D';

    /**
     * @var string
     */
    public const DEFER90 = 'DEFER_90D';

    /**
     * @var string
     */
    public const DEFER120 = 'DEFER_120D';
}
