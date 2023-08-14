<?php
/*
 * Copyright (c) WEBiDEA
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
 * @method $this setStreet(string $street)
 * @method string|null getHouseNumber()
 * @method $this setHouseNumber(string $houseNumber)
 * @method string getPostcode()
 * @method $this setPostcode(string $postcode)
 * @method string getCity()
 * @method $this setCity(string $city)
 * @method string getCountry()
 * @method $this setCountry(string $country)
 * @method $this setAdditional(string|null $additional)
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
        $validations['country'] = static function ($value): string {
            if (strlen((string) $value) !== 2) {
                throw new InvalidFieldValueException('country should be a two-letter uppercase string. (country in ISO-alpha-2)');
            }

            return Validation::TYPE_STRING_REQUIRED;
        };

        return $validations;
    }
}
