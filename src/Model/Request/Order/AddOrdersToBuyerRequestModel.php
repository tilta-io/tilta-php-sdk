<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\Order\AbstractAddOrdersToBuyerModel;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder;
use Tilta\Sdk\Model\Request\RequestModelInterface;

class AddOrdersToBuyerRequestModel extends AbstractAddOrdersToBuyerModel implements HasBuyerFieldInterface, RequestModelInterface
{
    protected string $buyerExternalId;

    protected static array $_additionalFieldMapping = [
        'buyerExternalId' => false,
    ];

    public function __construct(string $buyerExternalId)
    {
        parent::__construct();
        $this->buyerExternalId = $buyerExternalId;
    }

    /**
     * @param ExistingOrder[] $items
     */
    public function setItems(array $items): self
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__, [array_values($items)]);
    }

    public function addOrderItem(ExistingOrder $order): self
    {
        $this->items[] = $order;

        return $this;
    }

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    protected function getFieldValidations(): array
    {
        return [
            'items' => static function ($value): string {
                if ($value === []) {
                    throw new InvalidFieldValueException('you should add at least one order to the request model');
                }

                return ExistingOrder::class . '[]';
            },
        ];
    }
}
