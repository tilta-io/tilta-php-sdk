<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Order;

use DateTime;
use Throwable;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\Facility\FacilityExceededException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException;
use Tilta\Sdk\Model\Order\Amount;
use Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel;
use Tilta\Sdk\Model\Response\Facility;
use Tilta\Sdk\Model\Response\Order\GetPaymentTermsResponseModel;
use Tilta\Sdk\Model\Response\Order\PaymentTerm\PaymentTerm;
use Tilta\Sdk\Service\Request\Order\GetPaymentTermsRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;
use Tilta\Sdk\Tests\Helper\BuyerHelper;
use Tilta\Sdk\Tests\Helper\TiltaClientHelper;

class GetPaymentTermsRequestTest extends AbstractRequestTestCase
{
    public function testGetPaymentTermsOffline(): void
    {
        $expectedResponse = [
            'facility' => [
                'status' => 10000,
                'expires_at' => (new DateTime())->getTimestamp(),
                'currency' => 'EUR',
                'total_amount' => 10000,
                'available_amount' => 5200,
                'used_amount' => 4800,
            ],
            'payment_terms' => [
                [
                    'payment_method' => 'CASH',
                    'name' => 'Readable name',
                    'due_date' => (new DateTime())->getTimestamp(),
                    'amount' => [
                        'fee' => 12,
                        'fee_percentage' => 10,
                        'currency' => 'EUR',
                        'gross' => 1190,
                        'net' => 1000,
                        'tax' => 190,
                    ],
                ],
                [
                    'payment_method' => 'BNPL30',
                    'name' => 'Readable name',
                    'due_date' => (new DateTime())->getTimestamp(),
                    'amount' => [
                        'fee' => 12,
                        'fee_percentage' => 10,
                        'currency' => 'EUR',
                        'gross' => 1190,
                        'net' => 1000,
                        'tax' => 190,
                    ],
                ],
            ],
        ];
        $request = new GetPaymentTermsRequest($this->createMockedTiltaClientResponse($expectedResponse));

        $response = $request->execute($this->createMock(GetPaymentTermsRequestModel::class));
        static::assertInstanceOf(GetPaymentTermsResponseModel::class, $response);
        static::assertInstanceOf(Facility::class, $response->getFacility());
        static::assertIsArray($response->getPaymentTerms());
        static::assertCount(2, $response->getPaymentTerms());
        static::assertContainsOnlyInstancesOf(PaymentTerm::class, $response->getPaymentTerms());
        static::assertEquals('CASH', $response->getPaymentTerms()[0]->getPaymentMethod());
        static::assertEquals('BNPL30', $response->getPaymentTerms()[1]->getPaymentMethod());
    }

    public function testGetPaymentTermsOnline(): void
    {
        $request = new GetPaymentTermsRequest(TiltaClientHelper::getClient());

        $buyerId = BuyerHelper::getBuyerExternalIdWithValidFacility(__FUNCTION__);
        $model = (new GetPaymentTermsRequestModel())
            ->setBuyerExternalId($buyerId)
            ->setMerchantExternalId(TiltaClientHelper::getMerchantId())
            ->setAmount(
                (new Amount())
                    ->setGross(119)
                    ->setNet(100)
                    ->setTax(19)
                    ->setCurrency('EUR')
            );

        $response = $request->execute($model);
        static::assertInstanceOf(GetPaymentTermsResponseModel::class, $response);
        static::assertInstanceOf(Facility::class, $response->getFacility());
        static::assertIsArray($response->getPaymentTerms());
        static::assertContainsOnlyInstancesOf(PaymentTerm::class, $response->getPaymentTerms());
    }

    /**
     * @param class-string<Throwable> $expectedException
     * @dataProvider exceptionDataProvider
     */
    public function testExpectException(array $responseData, string $expectedException): void
    {
        $exception = new GatewayException(123, $responseData);
        $client = $this->createMockedTiltaClientException($exception);

        $this->expectException($expectedException);
        $model = $this->createMock(GetPaymentTermsRequestModel::class);
        $model->method('toArray')->willReturn([]);
        (new GetPaymentTermsRequest($client))->execute($model);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [['message' => 'No Buyer found'], BuyerNotFoundException::class],
            [['message' => 'No Merchant found'], MerchantNotFoundException::class],
            [['code' => 'FACILITY_EXCEEDED_AVAILABLE_AMOUNT'], FacilityExceededException::class],
        ];
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [GetPaymentTermsRequest::class, GetPaymentTermsRequestModel::class],
        ];
    }
}
