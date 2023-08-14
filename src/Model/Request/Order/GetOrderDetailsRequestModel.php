<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Model\Request\AbstractOrderRequestModel;

class GetOrderDetailsRequestModel extends AbstractOrderRequestModel
{
    public function toArray(): array
    {
        return [];
    }
}
