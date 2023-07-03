<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order;

use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Response\AbstractResponseModel;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method Order[] getItems()
 */
class GetOrderListForBuyerResponseModel extends AbstractResponseModel
{
    /**
     * @var Order[]
     */
    protected array $items = [];

    protected function prepareModelData(array $data): array
    {
        return [
            'items' => static fn ($key): ?array => ResponseHelper::getArray($data, null, Order::class),
        ];
    }
}
