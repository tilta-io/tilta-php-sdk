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
use Tilta\Sdk\Model\Response\Facility;

/**
 * @method Facility getFacility()
 * @method PaymentTerm[] getPaymentTerms()
 */
class GetPaymentTermsResponseModel extends AbstractResponseModel
{
    #[DefaultField]
    protected Facility $facility;

    /**
     * @var PaymentTerm[]
     */
    #[ListField(expectedItemClass: PaymentTerm::class)]
    protected array $paymentTerms = [];
}
