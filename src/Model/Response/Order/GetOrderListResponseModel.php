<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order;

use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Response\ListResponseModel;

/**
 * @extends ListResponseModel<Order>
 */
class GetOrderListResponseModel extends ListResponseModel
{
    #[ListField(expectedItemClass: Order::class)]
    protected array $items = [];
}
