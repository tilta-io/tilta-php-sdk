<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Helper;

abstract class AbstractHelper
{
    private static array $prefixCache = [];

    public static function createUniqueExternalId(string $testName, string $prefixCacheKey = null): string
    {
        $key = 'ut_' . $testName . '_' . uniqid();

        if ($prefixCacheKey !== null) {
            if (!isset(self::$prefixCache[$prefixCacheKey])) {
                self::$prefixCache[$prefixCacheKey] = $key;
            }

            return self::$prefixCache[$prefixCacheKey];
        }

        return $key;
    }
}
