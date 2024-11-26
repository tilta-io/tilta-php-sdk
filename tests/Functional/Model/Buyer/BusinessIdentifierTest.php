<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Buyer;

use Tilta\Sdk\Model\Buyer\BusinessIdentifier;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class BusinessIdentifierTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = new BusinessIdentifier();
        $model->setType(BusinessIdentifier::TYPE_VAT_ID);
        $model->setValue('test-123');
        $model->setCountry('GB');

        $data = $model->toArray();
        static::assertCount(3, $data);
        static::assertValueShouldBeInData(BusinessIdentifier::TYPE_VAT_ID, $data, 'type');
        static::assertValueShouldBeInData('test-123', $data, 'value');
        static::assertValueShouldBeInData('GB', $data, 'country');
    }

    public function testFromArray(): void
    {
        $model = new BusinessIdentifier();
        $model->fromArray([
            'type' => BusinessIdentifier::TYPE_VAT_ID,
            'value' => 'test-123',
            'country' => 'GB',
        ]);

        static::assertEquals(BusinessIdentifier::TYPE_VAT_ID, $model->getType());
        static::assertEquals('test-123', $model->getValue());
        static::assertEquals('GB', $model->getCountry());
    }
}
