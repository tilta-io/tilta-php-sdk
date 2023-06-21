<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Response\Request\Facility;

use DateTime;
use Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

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

        $this->assertEquals('buyer-external-id', $model->getBuyerExternalId());
        $this->assertEquals(123456, $model->getPendingOrdersAmount());
        $this->assertEquals('PENDING', $model->getStatus());
        $this->assertInstanceOf(DateTime::class, $model->getExpiresAt());
        $this->assertEquals(1686925869, $model->getExpiresAt()->getTimestamp());
        $this->assertEquals('EUR', $model->getCurrency());
        $this->assertEquals(54684, $model->getTotalAmount());
        $this->assertEquals(88476, $model->getAvailableAmount());
        $this->assertEquals(1342561, $model->getUsedAmount());
    }
}
