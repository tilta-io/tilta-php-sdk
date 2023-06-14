<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Buyer;

use Tilta\Sdk\Model\Response\AbstractResponseModel;
use Tilta\Sdk\Util\ResponseHelper;

class GetBuyerAuthTokenResponseModel extends AbstractResponseModel
{
    protected string $buyerAuthToken;

    public function fromArray(array $data): self
    {
        $this->buyerAuthToken = ResponseHelper::getStringNN($data, 'token');

        return $this;
    }

    public function getBuyerAuthToken(): string
    {
        return $this->buyerAuthToken;
    }
}
