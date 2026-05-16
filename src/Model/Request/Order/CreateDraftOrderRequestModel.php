<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Attributes\Validation\Required;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\HasOrderIdFieldInterface;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method string getOrderExternalId()
 * @method $this setOrderExternalId(string $orderExternalId)
 * @method string getBuyerExternalId()
 * @method $this setBuyerExternalId(string $buyerExternalId)
 * @method string|null getMerchantExternalId()
 * @method $this setMerchantExternalId(?string $merchantExternalId)
 * @method Amount getAmount()
 * @method $this setAmount(Amount $amount)
 * @method string|null getComment()
 * @method $this setComment(?string $comment)
 * @method array|null getCustomData()
 * @method $this setCustomData(?array $customData)
 * @method LineItem[] getLineItems()
 * @method $this setLineItems(LineItem[] $lineItems)
 * @method string|null getContactEmail()
 * @method $this setContactEmail(?string $contactEmail)
 */
class CreateDraftOrderRequestModel extends AbstractRequestModel implements HasOrderIdFieldInterface, HasBuyerFieldInterface, HasMerchantFieldInterface
{
    #[DefaultField(apiField: 'external_id')]
    #[Required]
    protected string $orderExternalId;

    #[DefaultField]
    #[Required]
    protected string $buyerExternalId;

    #[DefaultField]
    protected ?string $merchantExternalId = null;

    #[DefaultField]
    #[Required]
    protected Amount $amount;

    #[DefaultField]
    protected ?string $comment = null;

    #[DefaultField]
    protected ?array $customData = null;

    /**
     * @var LineItem[]
     */
    #[ListField(expectedItemClass: LineItem::class)]
    protected array $lineItems = [];

    #[DefaultField]
    protected ?string $contactEmail = null;

    public function getOrderExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
