<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request\Order;

use Tilta\Sdk\Model\Request\Order\GetCheckoutLinkRequestModel;
use Tilta\Sdk\Model\Response\Order\GetCheckoutLinkResponse;
use Tilta\Sdk\Service\Request\AbstractRequest;

/**
 * @extends AbstractRequest<GetCheckoutLinkRequestModel, GetCheckoutLinkResponse>
 */
class GetCheckoutLinkRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'orders/' . $requestModel->getOrderExternalId() . '/checkout-link';
    }

    protected static function getExpectedRequestModelClass(): string
    {
        return GetCheckoutLinkRequestModel::class;
    }

    protected function processSuccess($requestModel, array $responseData): GetCheckoutLinkResponse
    {
        return (new GetCheckoutLinkResponse())->fromArray($responseData);
    }
}
