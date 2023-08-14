<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Facility;

use Tilta\Sdk\Model\Response\Facility;

/**
 * @method string getBuyerExternalId()
 * @method int getPendingOrdersAmount()
 */
class GetFacilityResponseModel extends Facility
{
    protected int $pendingOrdersAmount;

    protected string $buyerExternalId;
}
