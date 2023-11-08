<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\PaymentTerm;

use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Request\PaymentTerm\GetPaymentTermsRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetPaymentTermsRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new GetPaymentTermsRequestModel())
            ->setBuyerExternalId('buyer-id')
            ->setMerchantExternalId('merchant-id')
            ->setAmount(
                (new Amount())
                    ->setGross(119)
                    ->setNet(100)
                    ->setTax(19)
                    ->setCurrency('EUR')
            );

        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(3, $data);
        static::assertArrayNotHasKey('buyer_external_id', $data, 'buyer-id should not by in the request-data');
        static::assertEquals('buyer-id', $model->getBuyerExternalId());
        static::assertValueShouldBeInData('merchant-id', $data, 'merchant_external_id');
        static::assertArrayNotHasKey('amount', $data);
        static::assertValueShouldBeInData(119, $data, 'gross_amount');
        static::assertValueShouldBeInData('EUR', $data, 'currency');
    }
}
