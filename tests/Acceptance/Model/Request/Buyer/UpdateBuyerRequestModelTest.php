<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Request\Buyer;

use Tilta\Sdk\Model\Request\Buyer\UpdateBuyerRequestModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;

class UpdateBuyerRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = BuyerHelper::fillUpBuyerObject(new UpdateBuyerRequestModel('Test-123'));
        $data = $model->toArray();

        self::assertIsArray($data);
        self::assertCount(8, $data);
        self::assertArrayHasKey('trading_name', $data);
        self::assertArrayHasKey('legal_name', $data);
        self::assertArrayHasKey('legal_form', $data);
        self::assertArrayHasKey('registered_at', $data);
        self::assertArrayHasKey('incorporated_at', $data);
        self::assertArrayHasKey('representatives', $data);
        self::assertIsArray($data['representatives']);
        self::assertArrayHasKey('business_address', $data);
        self::assertIsArray($data['business_address']);
        self::assertArrayHasKey('custom_data', $data);
        self::assertIsArray($data['custom_data']);
    }

    public function testNullableFields(): void
    {
        // the request allows all fields to be empty.
        // cause the model extends the Buyer-Model, which does have required fields, we need to check if it is possible
        // to get an empty array from model, if no values has been set.
        // no validation exception should be thrown.

        $model = new UpdateBuyerRequestModel('Test-123');
        $outputData = $model->toArray();
        self::assertIsArray($outputData);
        self::assertEquals([], $outputData); // also no empty key/value pairs should be created, to make sure that no null-values got submitted
    }
}
