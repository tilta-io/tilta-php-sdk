<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer;

use BadMethodCallException;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyerRequestModel;

class ExistingOrder extends Order
{
    protected string $buyerExternalId = '';

    #[DefaultField(apiField: 'external_id')]
    protected string $orderExternalId;

    /**
     * @internal do not use!
     */
    public function setBuyerExternalId(string $buyerExternalId): void
    {
        throw new BadMethodCallException('you can not set the buyerExternalId for this model. Please set to ' . AddOrdersToBuyerRequestModel::class);
    }

    /**
     * @internal do not use!
     */
    public function getBuyerExternalId(): string
    {
        throw new BadMethodCallException('you can not get the buyerExternalId from this model. Please get from ' . AddOrdersToBuyerRequestModel::class);
    }
}
