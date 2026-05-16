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
 * @method DateTimeInterface getDueAt()
 * @method PaymentTermInstallmentAmount getAmount()
 */
class PaymentTermInstallment extends AbstractResponseModel
{
    #[DefaultField]
    protected DateTimeInterface $dueAt;

    #[DefaultField]
    protected PaymentTermInstallmentAmount $amount;
}
