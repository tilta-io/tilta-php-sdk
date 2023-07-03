<?php
/*
 * Copyright (c) Tilta Fintech GmbH
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
class GetOrderDetailsRequestModel extends AbstractRequestModel implements HasOrderIdFieldInterface
{
    protected string $orderExternalId;

    public function __construct(string $externalId)
    {
        parent::__construct();
        $this->orderExternalId = $externalId;
    }

    public function getOrderExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }

    public function toArray(): array
    {
        return [];
    }
}
