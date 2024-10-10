<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order;

use Tilta\Sdk\Model\Order\AbstractAddOrdersToBuyerModel;

class AddOrdersToBuyerResponseModel extends AbstractAddOrdersToBuyerModel
{
    public function fromArray(array $data): self
    {
        return parent::fromArray([
            'items' => $data,
        ]);
    }
}
