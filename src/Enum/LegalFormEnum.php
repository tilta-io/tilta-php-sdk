<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Enum;

class LegalFormEnum
{
    public const PREFIX_REGEX = '/^[A-Z]{2}_/';

    public const LEGAL_FORMS = [
        ...self::LEGAL_FORMS_DE,
        ...self::LEGAL_FORMS_AT,
        ...self::LEGAL_FORMS_PL,
        ...self::LEGAL_FORMS_NL,
    ];

    public const LEGAL_FORMS_DE = [
        'DE_AG',
        'DE_EG',
        'DE_EK',
        'DE_EV',
        'DE_FREELANCER',
        'DE_GBR',
        'DE_GEWERBEBETRIEB',
        'DE_GMBH',
        'DE_GMBH_CO_KG',
        'DE_KDOR',
        'DE_KG',
        'DE_OHG',
        'DE_PRIVATE_PERSON',
        'DE_UG',
        'DE_EINZELUNTERNEHMER',
    ];

    public const LEGAL_FORMS_AT = [
        'AT_SR',
        'AT_OG',
        'AT_KG',
        'AT_AG',
        'AT_GBR',
        'AT_GMBH',
    ];

    public const LEGAL_FORMS_PL = [
        'PL_SA',
        'PL_SC',
        'PL_SJ',
        'PL_SKA',
        'PL_SPK',
        'PL_SPP',
    ];

    public const LEGAL_FORMS_NL = [
        'NL_BV',
        'NL_NV',
        'NL_VOF',
        'NL_CV',
        'NL_MAATSCHAP',
    ];

    public static function getLegalFormsForCountryWithoutPrefix(string $country): array
    {
        $country = strtoupper($country);
        $list = static::getLegalFormsForCountry($country);

        return array_map(static fn ($item) => preg_replace(static::PREFIX_REGEX, '', $item), $list);
    }

    public static function getLegalFormsForCountry(string $country): array
    {
        $country = strtoupper($country);

        return array_filter(self::LEGAL_FORMS, static fn (string $item) => preg_match('/^' . $country . '_/', $item));
    }

    public static function removePrefix(string $legalForm): string
    {
        return preg_replace(self::PREFIX_REGEX, '', $legalForm) ?: $legalForm;
    }
}
