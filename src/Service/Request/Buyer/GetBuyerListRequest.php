<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Buyer;

use Tilta\Sdk\Model\Request\Buyer\GetBuyersListRequestModel;
use Tilta\Sdk\Model\Response\Buyer\GetBuyersListResponseModel;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetBuyersListRequestModel, GetBuyersListResponseModel>
 */
class GetBuyerListRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'buyers';
    }

    protected function processSuccess($requestModel, array $responseData): GetBuyersListResponseModel
    {
        return new GetBuyersListResponseModel($responseData);
    }
}
