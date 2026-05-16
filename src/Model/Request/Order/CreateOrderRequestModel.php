<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use BadMethodCallException;
use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\Validation\Required;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\RequestModelInterface;

/**
 * @method $this setOrderExternalId(string $orderExternalId)
 * @method $this setBuyerExternalId(string $buyerExternalId)
 * @method $this setMerchantExternalId(string $merchantExternalId)
 * @method $this setOrderedAt(DateTimeInterface $orderedAt)
 * @method $this setPaymentMethod(string $paymentMethod)
 * @method $this setPaymentTerm(string $paymentTerm)
 * @method $this setAmount(Amount $amount)
 * @method $this setComment(?string $comment)
 * @method $this setDeliveryAddress(?Address $deliveryAddress)
 * @method $this setLineItems(LineItem[] $lineItems)
 */
class CreateOrderRequestModel extends Order implements RequestModelInterface
{
    // removed field definition
    protected ?string $status;

    #[DefaultField]
    #[Required]
    protected ?DateTimeInterface $orderedAt;

    #[DefaultField]
    #[Required]
    protected ?string $paymentMethod;

    #[DefaultField]
    #[Required]
    protected ?string $paymentTerm;

    /**
     * @internal
     */
    final public function getStatus(): never
    {
        throw new BadMethodCallException('getting this property is not allowed.');
    }

    /**
     * @internal
     */
    final public function setStatus(string $status): self
    {
        throw new BadMethodCallException('setting this property is not allowed.');
    }
}
