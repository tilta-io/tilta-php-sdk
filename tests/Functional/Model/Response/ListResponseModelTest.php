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
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;
use Tilta\Sdk\Tests\Functional\Mock\Model\ArrayTestModelChild;

class ListResponseModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new ListResponseModel(ArrayTestModelChild::class, [
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
        $this->assertInstanceOf(ArrayTestModelChild::class, $model->getItems()[0]);
        $this->assertInstanceOf(ArrayTestModelChild::class, $model->getItems()[1]);
        $this->assertInstanceOf(ArrayTestModelChild::class, $model->getItems()[2]);
    }
}
