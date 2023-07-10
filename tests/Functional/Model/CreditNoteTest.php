<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

class CreditNoteTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $inputData = [
            'external_id' => 'credit-note-external-id',
            'date' => 1688402226,
            'total_amount' => 900,
            'currency' => 'EUR',
            'delivery_address' => ResponseHelper::PHPUNIT_OBJECT,
            'line_items' => [
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
            ],
            //"platform_id" => '0', // TODO don't know what this parameter is.
            'buyer_id' => 'buyer-external-id',
            'merchant_id' => 'merchant-external-id',
        ];

        $model = (new CreditNote())->fromArray($inputData);
        static::assertEquals('credit-note-external-id', $model->getCreditNoteExternalId());
        static::assertEquals('buyer-external-id', $model->getBuyerExternalId());
        static::assertInstanceOf(DateTime::class, $model->getCreatedAt());
        static::assertEquals(1688402226, $model->getCreatedAt()->getTimestamp());
        static::assertEquals('EUR', $model->getCurrency());
        static::assertInstanceOf(Address::class, $model->getBillingAddress());
        static::assertEquals(900, $model->getTotalAmount());
        static::assertIsArray($model->getLineItems());
        static::assertCount(3, $model->getLineItems());
        static::assertContainsOnlyInstancesOf(LineItem::class, $model->getLineItems());
    }
}
