<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use Tilta\Sdk\Model\Request\Order\GetOrderListForBuyerRequestModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetOrderListForBuyerRequestModelTest extends AbstractModelTestCase
{
    public function testDataFromModel(): void
    {
        $model = (new GetOrderListForBuyerRequestModel('buyer-id'));

        $data = $model->toArray();

        self::assertEquals([], $data, 'the model should return an empty array.');
        static::assertEquals('buyer-id', $model->getBuyerExternalId());
    }
}
