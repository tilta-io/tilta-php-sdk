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
use Tilta\Sdk\Enum\OrderStatusEnum;
use Tilta\Sdk\Enum\PaymentMethodEnum;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel;

class OrderHelper extends AbstractHelper
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

    /**
     * @template T of Order
     * @param class-string<T> $class
     * @return T
     */
    public static function createValidOrderWithStatus(string $externalId, string $status = OrderStatusEnum::PENDING_CONFIRMATION, string $class = Order::class): Order
    {
        $order = self::createValidOrder($externalId, 'buyer-id');
        $data = $order->toArray();
        $data['status'] = $status;

        return (new $class())->fromArray($data);
    }

    public static function createUniqueExternalId(string $testName, string $prefixCacheKey = null): string
    {
        return parent::createUniqueExternalId($testName, $prefixCacheKey) . '-order';
    }
}
