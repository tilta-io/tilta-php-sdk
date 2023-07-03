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
use Tilta\Sdk\Enum\PaymentMethodEnum;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Order\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel;

class OrderHelper
{
    public static function createValidOrder(string $externalId, string $buyerExternalId): CreateOrderRequestModel
    {
        return (new CreateOrderRequestModel())
            ->setOrderExternalId($externalId)
            ->setMerchantExternalId(TiltaClientHelper::getMerchantId())
            ->setBuyerExternalId($buyerExternalId)
            ->setOrderedAt(new DateTime())
            ->setComment('test order from phpunit (sdk)')
            ->setDeliveryAddress(
                (new Address())
                    ->setStreet('street name')
                    ->setHouseNumber('1234 a-g')
                    ->setPostcode('12345')
                    ->setCity('Test city')
                    ->setCountry('DE')
                    ->setAdditional('c/o unit-tester')
            )
            ->setLineItems([
                (new LineItem())
                    ->setName('Line Item 1')
                    ->setQuantity(2)
                    ->setCategory('unknown category')
                    ->setCurrency('EUR')
                    ->setDescription('product description')
                    ->setPrice(25),

                (new LineItem())
                    ->setName('Line Item 2')
                    ->setQuantity(1)
                    ->setCategory('another unknown category')
                    ->setCurrency('EUR')
                    ->setDescription('another product description')
                    ->setPrice(75),
            ])
            ->setAmount(
                (new Amount())
                    ->setCurrency('EUR')
                    ->setTax(190)
                    ->setNet(1000)
                    ->setGross(1190)
            )
            ->setPaymentMethod(PaymentMethodEnum::BNPL);
    }

    public static function createUniqueExternalId(string $testName): string
    {
        return 'unit-testing_' . $testName . '_' . round(microtime(true));
    }
}
