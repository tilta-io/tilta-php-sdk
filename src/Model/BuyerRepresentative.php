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
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string|null getSalutation()
 * @method self setSalutation(?string $salutation)
 * @method string|null getFirstname()
 * @method self setFirstname(?string $firstname)
 * @method string|null getLastname()
 * @method self setLastname(?string $lastname)
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

    protected ?string $firstname = null;

    protected ?string $lastname = null;

    protected ?DateTime $birthDate = null;

    protected ?string $email = null;

    protected ?string $phone = null;

    protected ?Address $address = null;

    public function fromArray(array $data): self
    {
        $this->salutation = ResponseHelper::getString($data, 'salutation');
        $this->firstname = ResponseHelper::getString($data, 'first_name');
        $this->lastname = ResponseHelper::getString($data, 'last_name');
        $this->birthDate = ResponseHelper::getDate($data, 'birth_date', 'U');
        $this->email = ResponseHelper::getString($data, 'email');
        $this->phone = ResponseHelper::getString($data, 'phone');
        $this->address = ResponseHelper::getObject($data, 'address', Address::class);

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['birth_date'] = $data['birth_date'] instanceof DateTime ? $data['birth_date']->getTimestamp() : null;

        $data['first_name'] = $data['firstname'];
        $data['last_name'] = $data['lastname'];
        unset($data['firstname'], $data['lastname']);

        return $data;
    }

    protected function getFieldValidations(): array
    {
        $validation = parent::getFieldValidations();

        $validation['salutation'] = static function ($that, $value) use ($validation) {
            $allowedValues = ['MR', 'MRS'];
            if (!in_array($value, $allowedValues, true)) {
                throw new InvalidFieldValueException('salutation has to be one of ' . implode('or ', $allowedValues));
            }

            return $validation['salutation'] ?? null;
        };

        return $validation;
    }
}
