<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Enum;

final class OrderStatusEnum
{
    /**
     * @var string
     */
    public const DRAFT = 'DRAFT';

    /**
     * please note the "typo" with double L.
     * this is the british variant of CANCELED.
     *
     * We are developing in american english. This is the reason why the constant is named with a single L.
     *
     * @var string
     */
    public const CANCELED = 'CANCELLED';

    /**
     * @var string
     */
    public const CLOSED = 'CLOSED';

    /**
     * @var string
     */
    public const PENDING_CONFIRMATION = 'PENDING_CONFIRMATION';

    /**
     * @var string
     */
    public const CONFIRMED = 'CONFIRMED';

    /**
     * @var string
     */
    public const EXPIRED = 'EXPIRED';

    /**
     * @var string
     */
    public const DISBURSED = 'DISBURSED';

    /**
     * @var string
     */
    public const IN_ARREALS = 'IN_ARREALS';
}
