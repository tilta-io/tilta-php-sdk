<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response;

use DateTime;
use Tilta\Sdk\Enum\PaymentMethodEnum;
use Tilta\Sdk\Enum\PaymentTermEnum;
use Tilta\Sdk\Model\Response\PaymentTerm\GetPaymentTermsResponseModel;
use Tilta\Sdk\Model\Response\PaymentTerm\PaymentTermFee;
use Tilta\Sdk\Model\Response\PaymentTerm\PaymentTermInstallment;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetPaymentTermsResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $inputData = [
            'facility' => [
                'status' => 'ACTIVE',
                'reviewed_at' => (new DateTime())->setDate(2023, 1, 1)->getTimestamp(),
                'currency' => 'EUR',
                'total_amount' => 10000,
                'available_amount' => 5200,
                'used_amount' => 4800,
            ],
            'payment_terms' => [
                [
                    'payment_method' => PaymentMethodEnum::CASH,
                    'payment_term' => PaymentTermEnum::BNPL30,
                    'fee' => [
                        'gross' => 119.0,
                        'net' => 100.0,
                        'tax' => 19.0,
                    ],
                    'installments' => [
                        [
                            'due_at' => (new DateTime())->setDate(2023, 2, 1)->getTimestamp(),
                            'amount' => [
                                'value' => 1190.0,
                                'currency' => 'EUR',
                            ],
                        ],
                    ],
                ],
                [
                    'payment_method' => PaymentMethodEnum::TRANSFER,
                    'payment_term' => PaymentTermEnum::BNPL7,
                    'fee' => [
                        'gross' => 50.0,
                        'net' => 42.0,
                        'tax' => 8.0,
                    ],
                    'installments' => [],
                ],
            ],
        ];

        $model = (new GetPaymentTermsResponseModel())->fromArray($inputData);

        static::assertCount(2, $model->getPaymentTerms());

        $firstTerm = $model->getPaymentTerms()[0];
        static::assertEquals(PaymentMethodEnum::CASH, $firstTerm->getPaymentMethod());
        static::assertEquals(PaymentTermEnum::BNPL30, $firstTerm->getPaymentTerm());
        static::assertInstanceOf(PaymentTermFee::class, $firstTerm->getFee());
        static::assertEquals(119.0, $firstTerm->getFee()->getGross());
        static::assertEquals(100.0, $firstTerm->getFee()->getNet());
        static::assertEquals(19.0, $firstTerm->getFee()->getTax());
        static::assertIsArray($firstTerm->getInstallments());
        static::assertCount(1, $firstTerm->getInstallments());
        static::assertContainsOnlyInstancesOf(PaymentTermInstallment::class, $firstTerm->getInstallments());
        static::assertEquals(1190.0, $firstTerm->getInstallments()[0]->getAmount()->getValue());
        static::assertEquals('EUR', $firstTerm->getInstallments()[0]->getAmount()->getCurrency());

        $secondTerm = $model->getPaymentTerms()[1];
        static::assertEquals(PaymentMethodEnum::TRANSFER, $secondTerm->getPaymentMethod());
        static::assertEquals(PaymentTermEnum::BNPL7, $secondTerm->getPaymentTerm());
        static::assertInstanceOf(PaymentTermFee::class, $secondTerm->getFee());
        static::assertIsArray($secondTerm->getInstallments());
        static::assertCount(0, $secondTerm->getInstallments());
    }
}
