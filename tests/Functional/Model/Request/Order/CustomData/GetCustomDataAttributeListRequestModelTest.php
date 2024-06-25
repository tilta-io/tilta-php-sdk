<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order\CustomData;

use Tilta\Sdk\Model\Request\ListRequestModel;
use Tilta\Sdk\Model\Request\Order\CustomData\GetCustomDataAttributeListRequestModel;
use Tilta\Sdk\Tests\Functional\Model\Request\ListRequestModelTest;

class GetCustomDataAttributeListRequestModelTest extends ListRequestModelTest
{
    protected function getModelInstance(): ListRequestModel
    {
        return new GetCustomDataAttributeListRequestModel();
    }
}
