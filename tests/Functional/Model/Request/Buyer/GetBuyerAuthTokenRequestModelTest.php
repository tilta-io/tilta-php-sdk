<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Buyer;

use Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetBuyerAuthTokenRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = new GetBuyerAuthTokenRequestModel('buyer-id');
        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(0, $data); // no data should be provided
        static::assertEquals('buyer-id', $model->getBuyerExternalId());
    }
}
