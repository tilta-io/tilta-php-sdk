<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\SepaMandate;

use DateTime;
use Tilta\Sdk\Model\Request\SepaMandate\CreateSepaMandateRequestModel;
use Tilta\Sdk\Model\Response\SepaMandate;
use Tilta\Sdk\Service\Request\SepaMandate\CreateSepaMandateRequest;
use Tilta\Sdk\Tests\Functional\Service\Request\AbstractRequestTestCase;

class CreateSepaMandateRequestTest extends AbstractRequestTestCase
{
    public function testRequest(): void
    {
        $mockedClient = $this->createMockedTiltaClientResponse([
            'mandate_id' => 'mandate-id',
            'created_at' => (new DateTime())->setDate(2023, 05, 19)->getTimestamp(),
        ]);

        $responseModel = (new CreateSepaMandateRequest($mockedClient))->execute(
            (new CreateSepaMandateRequestModel('buyer-external-id'))
                ->setIban('test-iban')
        );

        static::assertInstanceOf(SepaMandate::class, $responseModel);
        static::assertEquals('test-iban', $responseModel->getIban(), 'the request service should set the iban manually to make sure that the iban is also in the response model.');
    }

    public function testRequestWithIbanInResponse(): void
    {
        $mockedClient = $this->createMockedTiltaClientResponse([
            'mandate_id' => 'mandate-id',
            'created_at' => (new DateTime())->setDate(2023, 05, 19)->getTimestamp(),
            'iban' => 'iban in response',
        ]);

        $responseModel = (new CreateSepaMandateRequest($mockedClient))->execute(
            (new CreateSepaMandateRequestModel('buyer-external-id'))
                ->setIban('iban in request')
        );

        static::assertInstanceOf(SepaMandate::class, $responseModel);
        static::assertEquals('iban in response', $responseModel->getIban(), 'the request service should set the iban from the response and not from the request-model if a iban is given in the response.');
    }

    public function dataProviderExpectedRequestModel(): array
    {
        return [
            [CreateSepaMandateRequest::class, CreateSepaMandateRequestModel::class],
        ];
    }
}
