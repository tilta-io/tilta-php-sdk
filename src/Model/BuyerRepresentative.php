<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTime;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;

/**
 * @method string|null getSalutation()
 * @method self setSalutation(?string $salutation)
 * @method string|null getFirstName()
 * @method self setFirstName(?string $firstName)
 * @method string|null getLastName()
 * @method self setLastName(?string $lastName)
 * @method DateTime|null getBirthDate()
 * @method self setBirthDate(?DateTime $birthDate)
 * @method string|null getEmail()
 * @method self setEmail(?string $email)
 * @method string|null getPhone()
 * @method self setPhone(string|null $phone)
 * @method Address|null getAddress()
 * @method self setAddress(?Address $address)
 */
class BuyerRepresentative extends AbstractModel
{
    protected ?string $salutation = null;

    protected ?string $firstName = null;

    protected ?string $lastName = null;

    protected ?DateTime $birthDate = null;

    protected ?string $email = null;

    protected ?string $phone = null;

    protected ?Address $address = null;

    protected function getFieldValidations(): array
    {
        $validation = parent::getFieldValidations();

        $validation['salutation'] = static function ($value) use ($validation) {
            $allowedValues = ['MR', 'MRS'];
            if (!in_array($value, $allowedValues, true)) {
                throw new InvalidFieldValueException('salutation has to be one of ' . implode('or ', $allowedValues));
            }

            return $validation['salutation'] ?? null;
        };

        return $validation;
    }
}
