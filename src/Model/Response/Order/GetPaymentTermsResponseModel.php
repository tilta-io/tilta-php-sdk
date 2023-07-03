<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order;

use Tilta\Sdk\Model\Response\AbstractResponseModel;
use Tilta\Sdk\Model\Response\Order\PaymentTerm\LoanProduct;
use Tilta\Sdk\Model\Response\Order\PaymentTerm\PaymentTermFacility;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string getIban()
 * @method PaymentTermFacility getFacility()
 * @method LoanProduct[] getLoanProducts()
 */
class GetPaymentTermsResponseModel extends AbstractResponseModel
{
    protected string $iban;

    protected PaymentTermFacility $facility;

    /**
     * @var LoanProduct[]
     */
    protected array $loanProducts = [];

    protected function prepareModelData(array $data): array
    {
        return [
            'loanProducts' => static fn (string $key): ?array => ResponseHelper::getArray($data, $key, LoanProduct::class),
        ];
    }
}
