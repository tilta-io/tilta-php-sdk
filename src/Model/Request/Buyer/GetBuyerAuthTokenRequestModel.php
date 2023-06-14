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

class GetBuyerAuthTokenRequestModel extends AbstractBuyerRequestModel
{
    protected function _toArray(): array
    {
        return [];
    }
}
