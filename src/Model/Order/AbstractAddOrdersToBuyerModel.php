<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Order;

use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Order;

/**
 * @method Order[] getItems()
 */
abstract class AbstractAddOrdersToBuyerModel extends AbstractModel
{
    #[ListField(expectedItemClass: Order::class)]
    protected array $items = [];

    protected function _toArray(): array
    {
        $data = parent::_toArray();

        return $data['items'] ?? [];
    }
}
