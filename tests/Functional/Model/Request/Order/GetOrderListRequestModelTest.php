<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use Tilta\Sdk\Enum\PaymentMethodEnum;
use Tilta\Sdk\Model\Request\Order\GetOrderListRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetOrderListRequestModelTest extends AbstractModelTestCase
{
    public function testFullToArray(): void
    {
        $model = (new GetOrderListRequestModel())
            ->setMerchantExternalId('merchant-id')
            ->setPaymentMethod(PaymentMethodEnum::BNPL)
            ->setLimit(50)
            ->setOffset(150);

        $data = $model->toArray();

        self::assertIsArray($data);
        static::assertValueShouldBeInData('merchant-id', $data, 'merchant_external_id');
        static::assertValueShouldBeInData(PaymentMethodEnum::BNPL, $data, 'payment_method');
        static::assertValueShouldBeInData(50, $data, 'limit');
        static::assertValueShouldBeInData(150, $data, 'offset');
    }

    /**
     * @param mixed $value
     * @dataProvider optionalParametersDataProvider
     */
    public function testOptionalData(string $property, string $expectedParameterName, $value): void
    {
        $model = (new GetOrderListRequestModel());
        $model->__call('set' . ucfirst($property), [$value]);

        static::assertCount(1, $model->toArray(), 'there should be always only one entry in the request-data');
        static::assertEquals($value, $model->__call('get' . ucfirst($property)));
    }

    public function optionalParametersDataProvider(): array
    {
        return [
            ['merchantExternalId', 'merchant_id', 'merchant-id'],
            ['paymentMethod', 'payment_method', 'payment-method'],
            ['limit', 'limit', 10],
            ['offset', 'offset', 20],
        ];
    }
}
