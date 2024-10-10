<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method $this setBuyerExternalId(string $buyerExternalId)
 */
class GetOrderListForBuyerRequestModel extends AbstractRequestModel implements HasBuyerFieldInterface
{
    public function __construct(
        #[DefaultField]
        protected string $buyerExternalId
    ) {
        parent::__construct();
    }

    public function toArray(): array
    {
        return [];
    }

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
