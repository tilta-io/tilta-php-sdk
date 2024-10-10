<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\Validation\StringLength;

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
    #[DefaultField]
    protected ?string $street = null;

    #[DefaultField(apiField: 'house')]
    protected ?string $houseNumber = null;

    #[DefaultField]
    protected string $postcode;

    #[DefaultField]
    protected string $city;

    #[DefaultField]
    #[StringLength(minLength: 2, maxLength: 2, validationMessage: 'country should be a two-letter uppercase string. (country in ISO-alpha-2)')]
    protected string $country;

    #[DefaultField]
    protected ?string $additional = null;
}
