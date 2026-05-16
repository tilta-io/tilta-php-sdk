<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Response;

use DateTime;
use Tilta\Sdk\Model\Response\Facility;
use Tilta\Sdk\Model\Response\Facility\FacilityPendingAction;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class FacilityTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $inputData = [
            'status' => 'PENDING',
            'reviewed_at' => 1686925869,
            'currency' => 'EUR',
            'total_amount' => 54684,
            'available_amount' => 88476,
            'used_amount' => 1342561,
            'risk_band' => 'A1',
            'created_at' => 1686925800,
            'updated_at' => 1686925900,
            'pending_actions' => [
                [
                    'type' => 'CREATION',
                    'created_at' => 1686925800,
                ],
            ],
        ];
        $model = new Facility();
        $model->fromArray($inputData);

        self::assertEquals('PENDING', $model->getStatus());
        self::assertInstanceOf(DateTime::class, $model->getReviewedAt());
        self::assertEquals(1686925869, $model->getReviewedAt()->getTimestamp());
        self::assertEquals('EUR', $model->getCurrency());
        self::assertEquals(54684, $model->getTotalAmount());
        self::assertEquals(88476, $model->getAvailableAmount());
        self::assertEquals(1342561, $model->getUsedAmount());
        self::assertEquals('A1', $model->getRiskBand());
        self::assertInstanceOf(DateTime::class, $model->getCreatedAt());
        self::assertEquals(1686925800, $model->getCreatedAt()->getTimestamp());
        self::assertInstanceOf(DateTime::class, $model->getUpdatedAt());
        self::assertEquals(1686925900, $model->getUpdatedAt()->getTimestamp());
        self::assertIsArray($model->getPendingActions());
        self::assertCount(1, $model->getPendingActions());
        self::assertContainsOnlyInstancesOf(FacilityPendingAction::class, $model->getPendingActions());
        self::assertEquals('CREATION', $model->getPendingActions()[0]->getType());
    }
}
