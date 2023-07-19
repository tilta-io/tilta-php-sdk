<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order\PaymentTerm;

use DateTime;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method string getPaymentMethod()
 * @method string getName()
 * @method DateTime getDueDate()
 * @method PaymentTermAmount getAmount()
 */
class PaymentTerm extends AbstractResponseModel
{
    protected string $paymentMethod;

    protected string $name;

    protected DateTime $dueDate;

    protected PaymentTermAmount $amount;
}
