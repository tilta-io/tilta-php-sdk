<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order\CustomData;

use Tilta\Sdk\Model\Order\CustomDataAttribute;

class UpdateCustomDataAttributeRequestModel extends CustomDataAttribute
{
    protected static array $_additionalFieldMapping = [
        'name' => false, // request path
    ];
}
