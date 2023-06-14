<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

use Tilta\Sdk\HttpClient\TiltaClient;

class TiltaClientFactory
{
    /**
     * @var TiltaClient[]
     */
    private static array $instances = [];

    public static function getClientInstance(string $authToken, bool $isSandbox): TiltaClient
    {
        $key = md5(implode('+', [$authToken, $isSandbox ? '1' : '0']));
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new TiltaClient($authToken, $isSandbox);
        }

        return self::$instances[$key];
    }
}
