<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Order\LineItem;

/**
 * @method string getStatus()
 * @method DateTimeInterface getOrderedAt()
 * @method string getPaymentMethod()
 * @method string getPaymentTerm()
 * @method Amount getAmount()
 * @method string|null getComment()
 * @method Address|null getDeliveryAddress()
 * @method LineItem[] getLineItems()
 */
class Order extends AbstractModel implements HasOrderIdFieldInterface, HasMerchantFieldInterface, HasBuyerFieldInterface
{
    #[DefaultField(apiField: 'external_id')]
    protected string $orderExternalId;

    #[DefaultField]
    protected string $status;

    #[DefaultField]
    protected string $buyerExternalId;

    #[DefaultField]
    protected string $merchantExternalId;

    #[DefaultField]
    protected DateTimeInterface $orderedAt;

    #[DefaultField]
    protected string $paymentMethod;

    #[DefaultField]
    protected string $paymentTerm;

    #[DefaultField]
    protected Amount $amount;

    #[DefaultField]
    protected ?string $comment = null;

    #[DefaultField]
    protected ?Address $deliveryAddress = null;

    #[ListField(expectedItemClass: LineItem::class)]
    protected array $lineItems = [];

    public function getOrderExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
