<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order\PaymentTerm;

use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method int getTotalAmount()
 * @method int getAvailableAmount()
 * @method int getUsedAmount()
 */
class PaymentTermFacility extends AbstractResponseModel
{
    protected int $totalAmount;

    protected int $availableAmount;

    protected int $usedAmount;
}
