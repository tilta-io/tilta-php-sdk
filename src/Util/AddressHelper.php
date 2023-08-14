<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Util;

class AddressHelper
{
    /**
     * @var string
     */
    public const STREETNUMBER_REGEX = '/^([a-zäöüß\s\d.,-]+?)\s*([\d]+(?:\s?[a-z])?(?:\s?[-|+\/]{1}\s?\d*)?\s*[a-z]?)$/iu';

    public static function getStreetName(string $addressWithNumber): ?string
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return $matches[1] ?? null;
    }

    public static function getHouseNumber(string $addressWithNumber): ?string
    {
        $matches = self::regexMatchAddress($addressWithNumber);

        return $matches[2] ?? null;
    }

    private static function regexMatchAddress(string $addressWithNumber): array
    {
        preg_match(self::STREETNUMBER_REGEX, $addressWithNumber, $matches);

        return $matches;
    }
}
