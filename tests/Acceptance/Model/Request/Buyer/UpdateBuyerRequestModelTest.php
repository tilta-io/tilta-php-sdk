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

        $this->assertIsArray($data);
        $this->assertCount(8, $data);
        $this->assertArrayHasKey('trading_name', $data);
        $this->assertArrayHasKey('legal_name', $data);
        $this->assertArrayHasKey('legal_form', $data);
        $this->assertArrayHasKey('registered_at', $data);
        $this->assertArrayHasKey('incorporated_at', $data);
        $this->assertArrayHasKey('representatives', $data);
        $this->assertIsArray($data['representatives']);
        $this->assertArrayHasKey('business_address', $data);
        $this->assertIsArray($data['business_address']);
        $this->assertArrayHasKey('custom_data', $data);
        $this->assertIsArray($data['custom_data']);
    }

    public function testNullableFields(): void
    {
        // the request allows all fields to be empty.
        // cause the model extends the Buyer-Model, which does have required fields, we need to check if it is possible
        // to get an empty array from model, if no values has been set.
        // no validation exception should be thrown.

        $model = new UpdateBuyerRequestModel('Test-123');
        $outputData = $model->toArray();
        $this->assertIsArray($outputData);
        $this->assertEquals([], $outputData); // also no empty key/value pairs should be created, to make sure that no null-values got submitted
    }
}
