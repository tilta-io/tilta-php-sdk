<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response;

use DateTimeInterface;

/**
 * @method string getStatus()
 * @method DateTimeInterface getExpiresAt()
 * @method string getCurrency()
 * @method int getTotalAmount()
 * @method int getAvailableAmount()
 * @method int getUsedAmount()
 */
class Facility extends AbstractResponseModel
{
    protected string $status;

    protected DateTimeInterface $expiresAt;

    protected string $currency;

    protected int $totalAmount;

    protected int $availableAmount;

    protected int $usedAmount;
}
