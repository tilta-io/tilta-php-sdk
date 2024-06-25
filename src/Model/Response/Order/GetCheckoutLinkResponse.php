<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Order;

use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method string getUrl()
 */
class GetCheckoutLinkResponse extends AbstractResponseModel
{
    protected string $url;
}
