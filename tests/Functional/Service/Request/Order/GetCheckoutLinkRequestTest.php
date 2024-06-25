<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use Tilta\Sdk\Model\Request\Order\GetCheckoutLinkRequestModel;
use Tilta\Sdk\Model\Response\Order\GetCheckoutLinkResponse;
use Tilta\Sdk\Service\Request\Order\GetCheckoutLinkRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class GetCheckoutLinkRequestTest extends AbstractRequestTestCase
{
    public function testRequest(): void
    {
        $client = $this->createMockedTiltaClientResponse([
            'url' => 'https://example.com',
        ]);

        $model = (new GetCheckoutLinkRequestModel())
            ->setOrderExternalId('test-123');
        $responseModel = (new GetCheckoutLinkRequest($client))->execute($model);

        static::assertInstanceOf(GetCheckoutLinkResponse::class, $responseModel);
        static::assertEquals('https://example.com', $responseModel->getUrl());
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetCheckoutLinkRequest::class, GetCheckoutLinkRequestModel::class],
        ];
    }
}
