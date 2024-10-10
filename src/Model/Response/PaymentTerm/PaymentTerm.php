<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\PaymentTerm;

use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method string getPaymentMethod()
 * @method string getPaymentTerm()
 * @method string getName()
 * @method DateTimeInterface getDueDate()
 * @method PaymentTermAmount getAmount()
 */
class PaymentTerm extends AbstractResponseModel
{
    #[DefaultField]
    protected string $paymentMethod;

    #[DefaultField]
    protected string $paymentTerm;

    #[DefaultField]
    protected string $name;

    #[DefaultField]
    protected DateTimeInterface $dueDate;

    #[DefaultField]
    protected PaymentTermAmount $amount;
}
