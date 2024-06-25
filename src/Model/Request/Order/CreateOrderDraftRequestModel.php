<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Amount;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\HasOrderIdFieldInterface;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Model\Request\CustomDataTrait;
use Tilta\Sdk\Model\Request\RequestModelInterface;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method $this setOrderExternalId(string $orderExternalId)
 * @method $this setBuyerExternalId(string $buyerExternalId)
 * @method $this setMerchantExternalId(string $merchantExternalId)
 * @method Amount getAmount()
 * @method $this setAmount(Amount $amount)
 * @method string|null getComment()
 * @method $this setComment(?string $comment)
 * @method $this setLineItems(LineItem[] $lineItems)
 * @method LineItem[] getLineItems()
 */
class CreateOrderDraftRequestModel extends AbstractModel implements HasOrderIdFieldInterface, HasMerchantFieldInterface, HasBuyerFieldInterface, RequestModelInterface
{
    use CustomDataTrait;

    protected static array $_additionalFieldMapping = [
        'orderExternalId' => 'external_id',
    ];

    protected string $orderExternalId;

    protected string $buyerExternalId;

    protected string $merchantExternalId;

    protected Amount $amount;

    protected ?string $comment = null;

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

    protected function prepareValuesForGateway(array $data): array
    {
        if (isset($data['customData']) && $data['customData'] === []) {
            $data['customData'] = null;
        }

        return parent::prepareValuesForGateway($data);
    }
}
