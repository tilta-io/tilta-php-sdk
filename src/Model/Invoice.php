<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTimeInterface;
use Tilta\Sdk\Model\Order\Amount;
use Tilta\Sdk\Model\Order\LineItem;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string getInvoiceExternalId()
 * @method string[] getOrderExternalIds()
 * @method string getInvoiceNumber()
 * @method DateTimeInterface getInvoicedAt()
 * @method Amount getAmount()
 * @method Address getBillingAddress()
 * @method LineItem[] getLineItems()
 */
class Invoice extends AbstractModel
{
    protected static array $_additionalFieldMapping = [
        'invoiceExternalId' => 'external_id',
        'billingAddress' => 'delivery_address', // TILLSDK-15: got renamed in a future release
    ];

    protected string $invoiceExternalId;

    /**
     * @var string[]
     */
    protected array $orderExternalIds = [];

    protected string $invoiceNumber;

    protected DateTimeInterface $invoicedAt;

    protected Amount $amount;

    /**
     * @var LineItem[]
     */
    protected array $lineItems = [];

    protected Address $billingAddress;

    public function __construct(array $data = [], bool $readOnly = false)
    {
        parent::__construct($data, $readOnly);
    }

    protected function prepareModelData(array $data): array
    {
        return [
            'lineItems' => static fn (string $key): ?array => ResponseHelper::getArray($data, $key, LineItem::class),
        ];
    }
}
