<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order;

use Tilta\Sdk\Model\Request\Order\CancelOrderRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class CancelOrderRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new CancelOrderRequestModel('order-external-id'));
        $outputData = $model->toArray();

        self::assertIsArray($outputData);
        self::assertEquals([], $outputData, 'model should return an empty array, cause the external-id is a path parameter');
        self::assertEquals('order-external-id', $model->getOrderExternalId());
    }
}
