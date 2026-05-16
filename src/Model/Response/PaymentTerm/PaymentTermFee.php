<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\PaymentTerm;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method float getGross()
 * @method float getNet()
 * @method float getTax()
 */
class PaymentTermFee extends AbstractResponseModel
{
    #[DefaultField]
    protected float $gross;

    #[DefaultField]
    protected float $net;

    #[DefaultField]
    protected float $tax;
}
