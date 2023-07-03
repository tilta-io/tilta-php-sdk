<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order\PaymentTerm;

use Tilta\Sdk\Model\Response\AbstractResponseModel;
use Tilta\Sdk\Model\Response\Order\PaymentTerm\LoanProduct\LoanProductPayment;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method LoanProductPayment[] getPayments()
 */
class LoanProduct extends AbstractResponseModel
{
    /**
     * @var LoanProductPayment[]
     */
    protected array $payments = [];

    protected function prepareModelData(array $data): array
    {
        return [
            'payments' => static fn (string $key): ?array => ResponseHelper::getArray($data, $key, LoanProductPayment::class),
        ];
    }
}
