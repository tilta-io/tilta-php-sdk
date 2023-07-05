<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\FullTest;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\CreditNote;
use Tilta\Sdk\Model\Invoice;
use Tilta\Sdk\Model\Request\CreditNote\CreateCreditNoteRequestModel;
use Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Tilta\Sdk\Model\Request\Invoice\GetInvoiceRequestModel;
use Tilta\Sdk\Service\Request\CreditNote\CreateCreditNoteRequest;
use Tilta\Sdk\Service\Request\Invoice\CreateInvoiceRequest;
use Tilta\Sdk\Service\Request\Invoice\GetInvoiceRequest;

class FullPaymentProcessWithInvoiceTest extends AbstractFullPaymentProcessTestCase
{
    /**
     * @depends testCreateOrder
     */
    public function testCreateInvoice(): void
    {
        $requestModel = (new CreateInvoiceRequestModel())
            ->setInvoiceExternalId(self::$invoiceExternalId)
            ->setInvoiceNumber(self::$invoiceExternalId . '-number') // TODO clarify what the different between invoice_external_id & invoice_number is
            ->setOrderExternalIds([self::$orderExternalId])
            ->setAmount(self::$orderToBePlaced->getAmount())
            ->setLineItems(self::$orderToBePlaced->getLineItems())
            ->setInvoicedAt(new DateTime());

        if (($address = self::$orderToBePlaced->getDeliveryAddress()) instanceof Address) {
            $requestModel->setDeliveryAddress($address);
        }

        $responseModel = (new CreateInvoiceRequest(self::$client))->execute($requestModel);
        static::assertInstanceOf(Invoice::class, $responseModel);
    }

    /**
     * @depends testCreateInvoice
     */
    public function testGetInvoice(): void
    {
        $responseModel = (new GetInvoiceRequest(self::$client))->execute(new GetInvoiceRequestModel(self::$invoiceExternalId));
        static::assertInstanceOf(Invoice::class, $responseModel);
        static::assertEquals(self::$invoiceExternalId, $responseModel->getInvoiceExternalId());
    }

    /**
     * @depends testCreateInvoice
     */
    public function testCreateCreditNote(): void
    {
        $requestModel = (new CreateCreditNoteRequestModel())
            ->setCreditNoteExternalId(self::$creditNoteExternalId)
            ->setCreatedAt(new DateTime())
            ->setOrderExternalIds([self::$orderExternalId])
            ->setLineItems(self::$orderToBePlaced->getLineItems())
            ->setTotalAmount(self::$orderToBePlaced->getAmount()->getGross())
            ->setCurrency(self::$orderToBePlaced->getAmount()->getCurrency())
            ->setBuyerExternalId(self::$orderToBePlaced->getBuyerExternalId());

        if (($address = self::$orderToBePlaced->getDeliveryAddress()) instanceof Address) {
            $requestModel->setDeliveryAddress($address);
        }

        $responseModel = (new CreateCreditNoteRequest(self::$client))->execute($requestModel);
        static::assertInstanceOf(CreditNote::class, $responseModel);
    }
}
