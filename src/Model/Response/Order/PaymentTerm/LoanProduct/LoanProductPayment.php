<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order\PaymentTerm\LoanProduct;

use DateTime;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method DateTime getPaymentDate()
 * @method int getPaymentAmount()
 */
class LoanProductPayment extends AbstractResponseModel
{
    protected DateTime $paymentDate;

    protected int $paymentAmount;
}
