<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;
use Tilta\Sdk\Util\Validation;

/**
 * @method string|null getStreet()
 * @method self setStreet(string $street)
 * @method string|null getHouseNumber()
 * @method self setHouseNumber(string $houseNumber)
 * @method string getPostcode()
 * @method self setPostcode(string $postcode)
 * @method string getCity()
 * @method self setCity(string $city)
 * @method string getCountry()
 * @method self setCountry(string $country)
 * @method self setAdditional(string $additional)
 * @method string|null getAdditional()
 */
class Address extends AbstractModel
{
    protected ?string $street = null;

    protected ?string $houseNumber = null;

    protected string $postcode;

    protected string $city;

    protected string $country;

    protected ?string $additional = null;

    protected static array $_additionalFieldMapping = [
        'houseNumber' => 'house',
    ];

    protected function getFieldValidations(): array
    {
        $validations = parent::getFieldValidations();
        $validations['country'] = static function ($that, $value): string {
            if (strlen((string) $value) !== 2) {
                throw new InvalidFieldValueException('country should be a two-letter uppercase string. (country in ISO-alpha-2)');
            }

            return Validation::TYPE_STRING_REQUIRED;
        };

        return $validations;
    }
}
