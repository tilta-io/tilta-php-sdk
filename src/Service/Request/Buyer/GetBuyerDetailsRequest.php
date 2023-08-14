<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Buyer;

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

    protected function processSuccess($requestModel, array $responseData): Buyer
    {
        return new Buyer($responseData);
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetBuyerDetailsRequestModel::class;
    }
}
