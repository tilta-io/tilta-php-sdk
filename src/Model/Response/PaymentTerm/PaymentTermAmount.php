<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\PaymentTerm;

use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method int getFee()
 * @method int getFeePercentage()
 * @method int getGross()
 * @method string getCurrency()
 */
class PaymentTermAmount extends AbstractResponseModel
{
    protected int $fee;

    protected int $feePercentage;

    protected int $gross;

    protected string $currency;
}
