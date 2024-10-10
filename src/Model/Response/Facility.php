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
use Tilta\Sdk\Attributes\ApiField\DefaultField;

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
    #[DefaultField]
    protected string $status;

    #[DefaultField]
    protected DateTimeInterface $expiresAt;

    #[DefaultField]
    protected string $currency;

    #[DefaultField]
    protected int $totalAmount;

    #[DefaultField]
    protected int $availableAmount;

    #[DefaultField]
    protected int $usedAmount;
}
