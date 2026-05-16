<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response;

use Tilta\Sdk\Attributes\ApiField\DefaultField;

/**
 * @method string getToken()
 * @method string getUrl()
 */
class SessionResponseModel extends AbstractResponseModel
{
    #[DefaultField]
    protected string $token;

    #[DefaultField]
    protected string $url;
}
