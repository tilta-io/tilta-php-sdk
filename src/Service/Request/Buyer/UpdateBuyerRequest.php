<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Buyer;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\Request\Buyer\UpdateBuyerRequestModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<UpdateBuyerRequestModel, bool>
 */
class UpdateBuyerRequest extends AbstractRequest
{
    protected static bool $allowEmptyResponse = true;

    protected function getPath($requestModel): string
    {
        return 'buyers/' . $requestModel->getExternalId();
    }

    protected function processSuccess($requestModel, array $responseData): bool
    {
        return true;
    }

    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_POST;
    }
}
