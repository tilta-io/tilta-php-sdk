<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Buyer;

use Tilta\Sdk\Model\Request\AbstractBuyerRequestModel;
use Tilta\Sdk\Model\Request\EntityRequestModelInterface;

class GetBuyerDetailsRequestModel extends AbstractBuyerRequestModel implements EntityRequestModelInterface
{
    public function getExternalId(): string
    {
        return $this->getExternalBuyerId();
    }

    protected function _toArray(): array
    {
        return [];
    }
}
