<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Response\Facility;

use DateTime;
use Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetFacilityResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $inputData = [
            'buyer_external_id' => 'buyer-external-id',
            'pending_orders_amount' => 123456,
            'status' => 'PENDING',
            'expires_at' => 1686925869,
            'currency' => 'EUR',
            'total_amount' => 54684,
            'available_amount' => 88476,
            'used_amount' => 1342561,
        ];
        $model = new GetFacilityResponseModel();
        $model->fromArray($inputData);

        self::assertEquals('buyer-external-id', $model->getBuyerExternalId());
        self::assertEquals(123456, $model->getPendingOrdersAmount());
        self::assertEquals('PENDING', $model->getStatus());
        self::assertInstanceOf(DateTime::class, $model->getExpiresAt());
        self::assertEquals(1686925869, $model->getExpiresAt()->getTimestamp());
        self::assertEquals('EUR', $model->getCurrency());
        self::assertEquals(54684, $model->getTotalAmount());
        self::assertEquals(88476, $model->getAvailableAmount());
        self::assertEquals(1342561, $model->getUsedAmount());
    }
}
