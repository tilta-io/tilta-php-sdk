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
use Tilta\Sdk\Model\Order\AbstractAddOrdersToBuyerModel;
use Tilta\Sdk\Util\ResponseHelper;

class AddOrdersToBuyerResponseModel extends AbstractAddOrdersToBuyerModel
{
    protected function prepareModelData(array $data): array
    {
        return [
            'items' => static fn ($key): ?array => ResponseHelper::getArray($data, null, Order::class),
        ];
    }
}
