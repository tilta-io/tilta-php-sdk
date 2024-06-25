<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order\CustomData;

use Tilta\Sdk\Model\Order\CustomDataAttribute;
use Tilta\Sdk\Model\Response\ListResponseModel;

/**
 * @extends ListResponseModel<CustomDataAttribute>
 */
class GetCustomDataAttributeListResponse extends ListResponseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct(CustomDataAttribute::class, $data);
    }
}
