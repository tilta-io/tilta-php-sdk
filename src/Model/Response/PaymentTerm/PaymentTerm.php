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
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method string getPaymentMethod()
 * @method string getPaymentTerm()
 * @method PaymentTermFee getFee()
 * @method PaymentTermInstallment[] getInstallments()
 */
class PaymentTerm extends AbstractResponseModel
{
    #[DefaultField]
    protected string $paymentMethod;

    #[DefaultField]
    protected string $paymentTerm;

    #[DefaultField]
    protected PaymentTermFee $fee;

    /**
     * @var PaymentTermInstallment[]
     */
    #[ListField(expectedItemClass: PaymentTermInstallment::class)]
    protected array $installments = [];
}
