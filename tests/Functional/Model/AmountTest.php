<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use Tilta\Sdk\Model\Amount;

class AmountTest extends AbstractModelTestCase
{
    public function testFull(): void
    {
        $model = new Amount();
        $model->setNet(100);
        $model->setGross(119);
        $model->setTax(19);
        $model->setCurrency('EUR');

        $data = $model->toArray();
        static::assertCount(4, $data);
        static::assertInputOutputModel($data, $model);
        static::assertValueShouldBeInData(100, $data, 'net');
        static::assertValueShouldBeInData(119, $data, 'gross');
        static::assertValueShouldBeInData(19, $data, 'tax');
        static::assertValueShouldBeInData('EUR', $data, 'currency');
    }

    public function testIfTaxCanBeNull(): void
    {
        $model = new Amount();
        $model->setNet(100);
        $model->setGross(200);
        $model->setCurrency('EUR');

        $data = $model->toArray();
        static::assertCount(4, $data);
        static::assertInputOutputModel($data, $model);
        static::assertValueShouldBeInData(100, $data, 'net');
        static::assertValueShouldBeInData(200, $data, 'gross');
        static::assertValueShouldBeInData(0, $data, 'tax');
        static::assertValueShouldBeInData('EUR', $data, 'currency');
    }

    public function testTaxInResponseCanBeNull(): void
    {
        $model = (new Amount())->fromArray([
            'net' => 100,
            'gross' => 200,
            'currency' => 'EUR',
        ]);

        static::assertEquals(0, $model->getTax());
    }
}
