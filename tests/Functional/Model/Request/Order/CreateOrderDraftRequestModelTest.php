<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order;

use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;
use Tilta\Sdk\Tests\Helper\OrderHelper;

class CreateOrderDraftRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = OrderHelper::createValidDraft('test-order-external-id', 'test-buyer-external-id');
        $model->setCustomData([
            'test-field-1' => 'test-value-1',
            'test-field-2' => 'test-value-2',
        ]);

        $data = $model->toArray();
        self::assertIsArray($data);
        self::assertValueShouldBeInData('test-order-external-id', $data, 'external_id');
        self::assertValueShouldBeInData('test-buyer-external-id', $data, 'buyer_external_id');
        self::assertArrayHasKey('merchant_external_id', $data);
        self::assertArrayHasKey('amount', $data);
        self::assertIsArray($data['amount']);
        self::assertValueShouldBeInData('draft order from phpunit (sdk)', $data, 'comment');
        self::assertValueShouldBeInData([
            'test-field-1' => 'test-value-1',
            'test-field-2' => 'test-value-2',
        ], $data, 'custom_data');
        self::assertArrayHasKey('line_items', $data);
        self::assertCount(2, $data['line_items']);
    }

    public function testCustomDataIsNullIfEmpty(): void
    {
        $model = OrderHelper::createValidDraft('test', 'test');
        $model->setCustomData([]);

        $data = $model->toArray();
        self::assertArrayHasKey('custom_data', $data);
        self::assertNull($data['custom_data']);
    }
}
