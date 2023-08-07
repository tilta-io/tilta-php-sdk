<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTimeInterface;
use Tilta\Sdk\Model\Order\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string getStatus()
 * @method DateTimeInterface getOrderedAt()
 * @method string getPaymentMethod()
 * @method Amount getAmount()
 * @method string|null getComment()
 * @method Address|null getDeliveryAddress()
 * @method LineItem[] getLineItems()
 */
class Order extends AbstractModel implements HasOrderIdFieldInterface, HasMerchantFieldInterface, HasBuyerFieldInterface
{
    protected static array $_additionalFieldMapping = [
        'orderExternalId' => 'external_id',
    ];

    protected string $orderExternalId;

    protected string $status;

    protected string $buyerExternalId;

    protected string $merchantExternalId;

    protected DateTimeInterface $orderedAt;

    protected string $paymentMethod;

    protected Amount $amount;

    protected ?string $comment = null;

    protected ?Address $deliveryAddress = null;

    /**
     * @var LineItem[]
     */
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

    protected function getFieldValidations(): array
    {
        return [
            'lineItems' => LineItem::class . '[]',
        ];
    }

    protected function prepareModelData(array $data): array
    {
        return [
            'lineItems' => ResponseHelper::getArray($data, 'line_items', LineItem::class),
        ];
    }
}
