<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request;

use Tilta\Sdk\Model\Response\ListResponseModel;
use Tilta\Sdk\Tests\Functional\Mock\Model\SimpleTestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class ListResponseModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new ListResponseModel(SimpleTestModel::class, [
            'limit' => 500,
            'offset' => 2,
            'total' => 4000,
            'items' => [
                [
                    'field_value' => 'value 1',
                ],
                [
                    'field_value' => 'value 2',
                ],
                [
                    'field_value' => 'value 3',
                ],
            ],
        ]));

        $this->assertIsArray($model->getItems());
        $this->assertCount(3, $model->getItems());
        $this->assertInstanceOf(SimpleTestModel::class, $model->getItems()[0]);
        $this->assertInstanceOf(SimpleTestModel::class, $model->getItems()[1]);
        $this->assertInstanceOf(SimpleTestModel::class, $model->getItems()[2]);
    }
}
