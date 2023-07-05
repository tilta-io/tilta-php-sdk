<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Helper;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\CreditNote\CreateCreditNoteRequestModel;

class CreditNoteHelper extends AbstractHelper
{
    public static function createValidCreditNote(string $creditNoteExternalId): CreditNote
    {
        return (new CreditNote())->fromArray([
            'external_id' => $creditNoteExternalId,
            'date' => 1688402226,
            'total_amount' => 100,
            'currency' => 'EUR',
            'delivery_address' => [
                'street' => 'string',
                'house' => 'string',
                'postcode' => '12345',
                'city' => 'string',
                'country' => 'DE',
                'additional' => 'string',
            ],
            'line_items' => [
                [
                    'name' => 'line-item 1',
                    'category' => 'string',
                    'description' => 'string',
                    'price' => 25,
                    'currency' => 'EUR',
                    'quantity' => 2,
                ],
                [
                    'name' => 'line-item 2',
                    'category' => 'string',
                    'description' => 'string',
                    'price' => 50,
                    'currency' => 'EUR',
                    'quantity' => 1,
                ],
            ],
            //"platform_id" => '0', // TODO don't know what this parameter is.
            'buyer_id' => 'buyer-external-id',
            'merchant_id' => 'merchant-external-id',
        ]);
    }

    public static function createValidCreditNoteRequest(string $creditNoteExternalId): CreateCreditNoteRequestModel
    {
        return (new CreateCreditNoteRequestModel())
            ->setCreditNoteExternalId('credit-note-external-id')
            ->setBuyerExternalId('buyer-external-id')
            ->setCreatedAt((new DateTime())->setTimestamp(1688402371))
            ->setCurrency('EUR')
            ->setTotalAmount(900)
            ->setDeliveryAddress(
                (new Address())
                    ->setStreet('street')
                    ->setHouseNumber('123')
                    ->setCity('city')
                    ->setPostcode('12345')
                    ->setCountry('DE')
            )
            ->setLineItems([
                (new LineItem())
                    ->setName('line-item 1')
                    ->setDescription('description')
                    ->setCategory('category')
                    ->setPrice(25)
                    ->setCurrency('EUR')
                    ->setQuantity(2),
                (new LineItem())
                    ->setName('line-item 1')
                    ->setDescription('description')
                    ->setCategory('category')
                    ->setPrice(50)
                    ->setCurrency('EUR')
                    ->setQuantity(1),
            ])
            ->setOrderExternalIds(['order-external-id-1', 'order-external-id-2']);
    }

    public static function createUniqueExternalId(string $testName, string $prefixCacheKey = null): string
    {
        return parent::createUniqueExternalId($testName, $prefixCacheKey) . '-credit-note';
    }
}
