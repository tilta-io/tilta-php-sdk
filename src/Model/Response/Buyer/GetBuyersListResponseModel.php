<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Buyer;

use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\Response\ListResponseModel;

/**
 * @extends ListResponseModel<Buyer>
 */
class GetBuyersListResponseModel extends ListResponseModel
{
    #[ListField(expectedItemClass: Buyer::class)]
    protected array $items = [];
}
