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
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetPaymentTermsResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        // note: We will not create a test case for each submodel, as this would result in unnecessary overhead since the models are small.

        $inputData = [
            'facility' => [
                'status' => 10000,
                'expires_at' => (new DateTime())->setDate(2023, 1, 1)->getTimestamp(),
                'currency' => 'EUR',
                'total_amount' => 10000,
                'available_amount' => 5200,
                'used_amount' => 4800,
            ],
            'payment_terms' => [
                [
                    'payment_method' => 'CASH',
                    'name' => 'Readable name',
                    'due_date' => (new DateTime())->setDate(2023, 2, 1)->getTimestamp(),
                    'amount' => [
                        'fee' => 12,
                        'fee_percentage' => 10,
                        'currency' => 'EUR',
                        'gross' => 1190,
                        'net' => 1000,
                        'tax' => 190,
                    ],
                ],
                [
                    'payment_method' => 'BNPL30',
                    'name' => 'Readable name',
                    'due_date' => (new DateTime())->setDate(2023, 3, 1)->getTimestamp(),
                    'amount' => [
                        'fee' => 12,
                        'fee_percentage' => 10,
                        'currency' => 'EUR',
                        'gross' => 1190,
                        'net' => 1000,
                        'tax' => 190,
                    ],
                ],
            ],
        ];

        $model = (new GetPaymentTermsResponseModel())->fromArray($inputData);

        static::assertInputOutputModel($inputData, $model);
    }
}
