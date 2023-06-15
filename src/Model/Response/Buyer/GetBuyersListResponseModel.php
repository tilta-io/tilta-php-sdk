<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Buyer;

use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\Response\ListResponseModel;

/**
 * @extends ListResponseModel<Buyer>
 */
class GetBuyersListResponseModel extends ListResponseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct(Buyer::class, $data);
    }
}
