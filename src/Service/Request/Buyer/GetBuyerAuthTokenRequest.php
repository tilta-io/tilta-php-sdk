<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Buyer;

use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel;
use Tilta\Sdk\Model\Response\Buyer\GetBuyerAuthTokenResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetBuyerAuthTokenRequestModel, GetBuyerAuthTokenResponseModel>
 */
class GetBuyerAuthTokenRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'auth/buyer/' . $requestModel->getBuyerExternalId();
    }

    protected function processSuccess($requestModel, ?array $responseData = null): GetBuyerAuthTokenResponseModel
    {
        if (!is_array($responseData)) {
            throw new InvalidResponseException('got no response from gateway. A response was expected.');
        }

        return new GetBuyerAuthTokenResponseModel($responseData);
    }
}
