<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Order;

use Tilta\Sdk\Model\Order\CustomDataAttribute;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class CustomDataAttributeTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = new CustomDataAttribute();
        $model->setName('test-name');
        $model->setDescription('test-description');
        $model->setDataType('test-data-type');

        $data = $model->toArray();
        self::assertIsArray($data);
        self::assertCount(3, $data);
        self::assertEquals('test-name', $data['name']);
        self::assertEquals('test-description', $data['description']);
        self::assertEquals('test-data-type', $data['data_type']);
    }

    public function testFromArray(): void
    {
        $model = (new CustomDataAttribute())->fromArray([
            'name' => 'test-name',
            'description' => 'test-description',
            'data_type' => 'test-data-type',
        ]);

        self::assertEquals('test-name', $model->getName());
        self::assertEquals('test-description', $model->getDescription());
        self::assertEquals('test-data-type', $model->getDataType());
    }
}
