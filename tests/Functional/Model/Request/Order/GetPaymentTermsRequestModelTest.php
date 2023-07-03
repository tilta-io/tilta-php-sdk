<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Functional\Model\Request\Order;

use Tilta\Sdk\Model\Order\Amount;
use Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetPaymentTermsRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new GetPaymentTermsRequestModel())
            ->setBuyerExternalId('buyer-id')
            ->setMerchantExternalId('merchant-id')
            ->setAmount($this->createMock(Amount::class));

        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(2, $data);
        static::assertArrayNotHasKey('buyer_external_id', $data, 'buyer-id should not by in the request-data');
        static::assertEquals('buyer-id', $model->getBuyerExternalId());
        static::assertValueShouldBeInData('merchant-id', $data, 'merchant_external_id');
        static::assertValueShouldBeInData([], $data, 'amount');
    }
}
