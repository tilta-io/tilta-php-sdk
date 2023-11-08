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
use Tilta\Sdk\Model\Response\Facility;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method Facility getFacility()
 * @method PaymentTerm[] getPaymentTerms()
 */
class GetPaymentTermsResponseModel extends AbstractResponseModel
{
    protected Facility $facility;

    /**
     * @var PaymentTerm[]
     */
    protected array $paymentTerms = [];

    protected function prepareModelData(array $data): array
    {
        return [
            'paymentTerms' => static fn (string $key): ?array => ResponseHelper::getArray($data, $key, PaymentTerm::class),
        ];
    }
}
