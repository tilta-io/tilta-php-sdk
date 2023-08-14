<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response\Buyer;

use Tilta\Sdk\Model\Response\Buyer\GetBuyerAuthTokenResponseModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetBuyerAuthTokenResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $model = new GetBuyerAuthTokenResponseModel([
            'token' => 'my-token',
        ]);

        self::assertEquals('my-token', $model->getBuyerAuthToken());
    }
}
