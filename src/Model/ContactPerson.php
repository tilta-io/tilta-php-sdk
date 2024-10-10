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
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\Validation\Enum;

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
class ContactPerson extends AbstractModel
{
    #[DefaultField]
    #[Enum(['MR', 'MS'])]
    protected ?string $salutation = null;

    #[DefaultField]
    protected ?string $firstName = null;

    #[DefaultField]
    protected ?string $lastName = null;

    #[DefaultField]
    protected ?DateTimeInterface $birthDate = null;

    #[DefaultField]
    protected ?string $email = null;

    #[DefaultField]
    protected ?string $phone = null;

    #[DefaultField]
    protected ?Address $address = null;
}
