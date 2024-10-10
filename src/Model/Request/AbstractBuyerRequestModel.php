<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request;

use Tilta\Sdk\Model\HasBuyerFieldInterface;

abstract class AbstractBuyerRequestModel extends AbstractRequestModel implements HasBuyerFieldInterface
{
    public function __construct(
        protected string $externalBuyerId
    ) {
        parent::__construct();
    }

    public function getBuyerExternalId(): string
    {
        return $this->externalBuyerId;
    }
}
