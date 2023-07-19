<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order\PaymentTerm;

use Tilta\Sdk\Model\Order\Amount;

/**
 * @method int getFee()
 * @method int getFeePercentage()
 */
class PaymentTermAmount extends Amount
{
    protected int $fee;

    protected int $feePercentage;
}
