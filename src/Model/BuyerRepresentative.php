<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTimeInterface;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueException;

/**
 * @method string|null getSalutation()
 * @method $this setSalutation(?string $salutation)
 * @method string|null getFirstName()
 * @method $this setFirstName(?string $firstName)
 * @method string|null getLastName()
 * @method $this setLastName(?string $lastName)
 * @method DateTimeInterface|null getBirthDate()
 * @method $this setBirthDate(?DateTimeInterface $birthDate)
 * @method string|null getEmail()
 * @method $this setEmail(?string $email)
 * @method string|null getPhone()
 * @method $this setPhone(string|null $phone)
 * @method Address|null getAddress()
 * @method $this setAddress(?Address $address)
 */
class BuyerRepresentative extends AbstractModel
{
    protected ?string $salutation = null;

    protected ?string $firstName = null;

    protected ?string $lastName = null;

    protected ?DateTimeInterface $birthDate = null;

    protected ?string $email = null;

    protected ?string $phone = null;

    protected ?Address $address = null;

    protected function getFieldValidations(): array
    {
        $validation = parent::getFieldValidations();

        $validation['salutation'] = static function ($value) use ($validation) {
            $allowedValues = ['MR', 'MS'];
            if (!in_array($value, $allowedValues, true)) {
                throw new InvalidFieldValueException('salutation has to be one of ' . implode(' or ', $allowedValues));
            }

            return $validation['salutation'] ?? null;
        };

        return $validation;
    }
}
