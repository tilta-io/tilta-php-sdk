<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Invoice;

use Tilta\Sdk\Model\Request\Invoice\GetInvoiceListRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetInvoiceListRequestModelTest extends AbstractModelTestCase
{
    public function testFullToArray(): void
    {
        $model = (new GetInvoiceListRequestModel())
            ->setMerchantExternalId('merchant-id')
            ->setLimit(50)
            ->setOffset(150);

        $data = $model->toArray();

        self::assertIsArray($data);
        static::assertValueShouldBeInData('merchant-id', $data, 'merchant_external_id');
        static::assertValueShouldBeInData(50, $data, 'limit');
        static::assertValueShouldBeInData(150, $data, 'offset');
    }

    /**
     * @param mixed $value
     * @dataProvider optionalParametersDataProvider
     */
    public function testOptionalData(string $property, string $expectedParameterName, $value): void
    {
        $model = (new GetInvoiceListRequestModel());
        $model->__call('set' . ucfirst($property), [$value]);

        static::assertCount(1, $model->toArray(), 'there should be always only one entry in the request-data');
        static::assertEquals($value, $model->__call('get' . ucfirst($property)));
    }

    public function optionalParametersDataProvider(): array
    {
        return [
            ['merchantExternalId', 'merchant_id', 'merchant-id'],
            ['limit', 'limit', 10],
            ['offset', 'offset', 20],
        ];
    }
}
