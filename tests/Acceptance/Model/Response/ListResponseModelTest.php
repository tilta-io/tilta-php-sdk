<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Request;

use Tilta\Sdk\Model\Response\ListResponseModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class ListResponseModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $input = [
            'limit' => 500,
            'offset' => 2,
            'total' => 4000,
            'items' => [],
        ];
        // the given class does not make any sense. because we are not converting data, it does not matter which model got provided.
        $model = (new ListResponseModel(ListResponseModel::class))->fromArray($input);

        static::assertEquals(500, $model->getLimit());
        static::assertEquals(2, $model->getOffset());
        static::assertEquals(4000, $model->getTotal());
        static::assertIsArray($model->getItems());

        $this->assertInputOutputModel($input, $model);
    }
}
