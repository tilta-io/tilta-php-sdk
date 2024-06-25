<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Functional\Service\Request\Order;

use Tilta\Sdk\Model\Order;
use Tilta\Sdk\Model\Request\Order\CreateOrderDraftRequestModel;
use Tilta\Sdk\Service\Request\Order\CreateOrderDraftRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\OrderHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class CreateOrderDraftRequestTest extends AbstractRequestTestCase
{
    public function testCreateOrderDraft(): void
    {
        $client = TiltaClientHelper::getClient();
        $buyerExternalId = BuyerHelper::getBuyerExternalIdWithValidFacility($this->getName());
        $requestModel = OrderHelper::createValidDraft(OrderHelper::createUniqueExternalId($this->getName()), $buyerExternalId);

        $response = (new CreateOrderDraftRequest($client))->execute($requestModel);
        self::assertInstanceOf(Order::class, $response);
        self::assertEquals('DRAFT', $response->getStatus());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateOrderDraftRequest::class, CreateOrderDraftRequestModel::class],
        ];
    }
}
