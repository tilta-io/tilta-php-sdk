<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request;

use Tilta\Sdk\Model\HasOrderIdFieldInterface;

/**
 * @method $this setOrderExternalId(string $orderExternalId)
 */
abstract class AbstractOrderRequestModel extends AbstractRequestModel implements HasOrderIdFieldInterface
{
    public function __construct(
        protected string $orderExternalId
    ) {
        parent::__construct();
    }

    public function getOrderExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
