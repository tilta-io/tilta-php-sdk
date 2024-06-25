<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order\CustomData;

use Tilta\Sdk\Model\Request\Order\CustomData\UpdateCustomDataAttributeRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class UpdateCustomDataAttributeRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = new UpdateCustomDataAttributeRequestModel();
        $model->setName('test-name');
        $model->setDescription('test-description');
        $model->setDataType('test-data-type');

        $data = $model->toArray();
        self::assertIsArray($data);
        self::assertCount(2, $data);
        self::assertEquals('test-description', $data['description']);
        self::assertEquals('test-data-type', $data['data_type']);
    }
}
