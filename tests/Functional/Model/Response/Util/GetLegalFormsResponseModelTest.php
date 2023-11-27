<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Response\Util;

use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\Response\Util\GetLegalFormsResponseModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetLegalFormsResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $model = new GetLegalFormsResponseModel();
        $model->fromArray([
            [
                'name' => 'ABC',
                'display_name' => 'name 1',
            ],
            [
                'name' => 'DEF',
                'display_name' => 'name 2',
            ],
            [
                'name' => 'GHI',
                'display_name' => 'name 3',
            ],
        ]);

        static::assertIsArray($model->getItems());
        static::assertCount(3, $model->getItems());
        static::assertEquals('name 1', $model->getDisplayName('ABC'));
        static::assertEquals('name 2', $model->getDisplayName('DEF'));
        static::assertEquals('name 3', $model->getDisplayName('GHI'));
    }

    public function testIfInvalidResponseWithObjectGotHandled(): void
    {
        $model = new GetLegalFormsResponseModel();
        $this->expectException(InvalidResponseException::class);
        $model->fromArray([
            'key' => 'value',
            'key2' => 'value2',
        ]);
    }

    public function testIfInvalidResponseWithInvalidKeysGotHandled(): void
    {
        $model = new GetLegalFormsResponseModel();
        $this->expectException(InvalidResponseException::class);
        $model->fromArray([
            [
                '_name' => 'ABC',
                '*display_name' => 'name 1',
            ],
            [
                'name_' => 'DEF',
                'display_name_' => 'name 2',
            ],
            [
                'name*' => 'GHI',
                '*display_name' => 'name 3',
            ],
        ]);
    }
}
