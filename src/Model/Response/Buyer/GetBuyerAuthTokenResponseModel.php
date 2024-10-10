<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Buyer;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

class GetBuyerAuthTokenResponseModel extends AbstractResponseModel
{
    #[DefaultField(apiField: 'token')]
    protected string $buyerAuthToken;

    public function getBuyerAuthToken(): string
    {
        return $this->buyerAuthToken;
    }
}
