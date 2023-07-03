<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response\Order;

use DateTime;
use Tilta\Sdk\Model\Response\Order\GetPaymentTermsResponseModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetPaymentTermsResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        // note: We will not create a test case for each submodel, as this would result in unnecessary overhead since the models are small.

        $inputData = [
            'iban' => 'test-iban',
            'facility' => [
                'total_amount' => 10000,
                'available_amount' => 5200,
                'used_amount' => 4800,
            ],
            'loan_products' => [
                [
                    'payments' => [
                        [
                            'payment_date' => (new DateTime())->setDate(2023, 5, 23)->format('U'),
                            'payment_amount' => 6500,
                        ],
                        [
                            'payment_date' => (new DateTime())->setDate(2025, 9, 10)->format('U'),
                            'payment_amount' => 9600,
                        ],
                    ],
                ],
                [
                    'payments' => [
                        [
                            'payment_date' => (new DateTime())->setDate(2021, 5, 23)->format('U'),
                            'payment_amount' => 8460,
                        ],
                        [
                            'payment_date' => (new DateTime())->setDate(1950, 9, 10)->format('U'),
                            'payment_amount' => 8750,
                        ],
                    ],
                ],
            ],
        ];

        $model = (new GetPaymentTermsResponseModel())->fromArray($inputData);

        static::assertInputOutputModel($inputData, $model);
    }
}
