<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Facility;

use DateTime;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method string getBuyerExternalId()
 * @method string getStatus()
 * @method int getPendingOrderAmount()
 * @method DateTime getExpiresAt()
 * @method string getCurrency()
 * @method int getTotalAmount()
 * @method int getAvailableAmount()
 * @method int getUsedAmount()
 */
class GetFacilityResponseModel extends AbstractResponseModel
{
    protected string $buyerExternalId;

    protected int $pendingOrderAmount;

    protected string $status;

    protected DateTime $expiresAt;

    protected string $currency;

    protected int $totalAmount;

    protected int $availableAmount;

    protected int $usedAmount;
}
