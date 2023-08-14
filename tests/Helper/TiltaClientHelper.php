<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Helper;

use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Util\TiltaClientFactory;

class TiltaClientHelper
{
    public static function getClient(): TiltaClient
    {
        return TiltaClientFactory::getClientInstance(self::getToken(), true);
    }

    public static function getToken(): string
    {
        return (string) getenv('TILTA_API_TOKEN');
    }

    public static function getMerchantId(): string
    {
        return (string) getenv('TILTA_MERCHANT_ID');
    }
}
