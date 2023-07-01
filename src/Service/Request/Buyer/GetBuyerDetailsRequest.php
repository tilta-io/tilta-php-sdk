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
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetBuyerDetailsRequestModel, Buyer>
 */
class GetBuyerDetailsRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getBuyerExternalId();
    }

    protected function processSuccess($requestModel, ?array $responseData = null): Buyer
    {
        if (!is_array($responseData)) {
            throw new InvalidResponseException('got no response from gateway. A response was expected.');
        }

        return new Buyer($responseData);
    }
}
