<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Order;

use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Order;

/**
 * @method Order[] getItems()
 */
abstract class AbstractAddOrdersToBuyerModel extends AbstractModel
{
    /**
     * @var Order[]
     */
    protected array $items = [];

    protected function prepareValuesForGateway(array $data): array
    {
        return $data['items'];
    }
}
