<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response\SepaMandate;

use Tilta\Sdk\Model\Response\SepaMandate;
use Tilta\Sdk\Model\REsponse\SepaMandate\GetSepaMandateListResponseModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;
use Tilta\Sdk\Util\ResponseHelper;

class GetSepaMandateListResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $model = (new GetSepaMandateListResponseModel())->fromArray([
            'offset' => 5,
            'limit' => 10,
            'total' => 100,
            'items' => [
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
            ],
        ]);

        static::assertEquals(5, $model->getOffset());
        static::assertEquals(10, $model->getLimit());
        static::assertEquals(100, $model->getTotal());
        static::assertIsArray($model->getItems());
        static::assertCount(4, $model->getItems());
        static::assertContainsOnlyInstancesOf(SepaMandate::class, $model->getItems());
    }
}
