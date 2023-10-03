<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request;

use DateTime;
use Tilta\Sdk\Exception\Validation\InvalidFieldException;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\CreditNote\CreateCreditNoteRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class CreateCreditNoteRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new CreateCreditNoteRequestModel())
            ->setCreditNoteExternalId('credit-note-external-id')
            ->setBuyerExternalId('buyer-external-id')
            ->setInvoicedAt((new DateTime())->setTimestamp(1688402371))
            ->setAmount($this->createMock(Amount::class))
            ->setBillingAddress($this->createMock(Address::class))
            ->setLineItems([
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
                $this->createMock(LineItem::class),
            ])
            ->setOrderExternalIds(['order-external-id-1', 'order-external-id-2']);

        $outputData = $model->toArray();
        static::assertIsArray($outputData);
        static::assertCount(6, $outputData);
        static::assertArrayNotHasKey('buyer_external_id', $outputData);
        static::assertValueShouldBeInData('credit-note-external-id', $outputData, 'external_id');
        static::assertValueShouldBeInData(1688402371, $outputData, 'invoiced_at');
        static::assertValueShouldBeInData([], $outputData, 'billing_address');
        static::assertValueShouldBeInData([], $outputData, 'amount');
        static::assertValueShouldBeInData([[], [], [], []], $outputData, 'line_items');
        static::assertValueShouldBeInData(['order-external-id-1', 'order-external-id-2'], $outputData, 'order_external_ids');
    }

    /**
     * @dataProvider disallowedMethods
     */
    public function testDisallowedMethods(string $method, array $arguments): void
    {
        $this->expectException(InvalidFieldException::class);
        (new CreateCreditNoteRequestModel())->{$method}(...$arguments);
    }

    public function disallowedMethods(): array
    {
        return [
            ['getBuyerId', []],
            ['setBuyerId', []],
            ['getMerchantId', []],
            ['setMerchantId', ['']],
            ['getMerchantExternalId', []],
            ['setMerchantExternalId', ['']],
            ['getPlatformId', []],
            ['setPlatformId', ['']],
        ];
    }
}
