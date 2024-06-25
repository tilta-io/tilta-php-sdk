<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Model\HasOrderIdFieldInterface;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method $this setOrderExternalId(string $orderExternalId)
 */
class GetCheckoutLinkRequestModel extends AbstractRequestModel implements HasOrderIdFieldInterface
{
    protected string $orderExternalId;

    protected static array $_additionalFieldMapping = [
        'orderExternalId' => false,
    ];

    public function getOrderExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
