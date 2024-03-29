<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

class CreditNoteTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $inputData = [
            'external_id' => 'credit-note-external-id',
            'invoiced_at' => 1688402226,
            'amount' => ResponseHelper::PHPUNIT_OBJECT,
            'currency' => 'EUR',
            'billing_address' => ResponseHelper::PHPUNIT_OBJECT,
            'line_items' => [
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
                ResponseHelper::PHPUNIT_OBJECT,
            ],
        ];

        $model = (new CreditNote())->fromArray($inputData);
        static::assertEquals('credit-note-external-id', $model->getCreditNoteExternalId());
        static::assertInstanceOf(DateTime::class, $model->getInvoicedAt());
        static::assertEquals(1688402226, $model->getInvoicedAt()->getTimestamp());
        static::assertInstanceOf(Address::class, $model->getBillingAddress());
        static::assertInstanceOf(Amount::class, $model->getAmount());
        static::assertIsArray($model->getLineItems());
        static::assertCount(3, $model->getLineItems());
        static::assertContainsOnlyInstancesOf(LineItem::class, $model->getLineItems());
    }
}
