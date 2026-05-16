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
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Attributes\Validation\Required;
use Tilta\Sdk\Model\Buyer\BusinessIdentifier;

/**
 * @method string getExternalId()
 * @method $this setExternalId(string $externalId)
 * @method string|null getTradingName()
 * @method $this setTradingName(?string $tradingName)
 * @method string getLegalName()
 * @method $this setLegalName(string $legalName)
 * @method string|null getLegalForm()
 * @method $this setLegalForm(?string $legalForm)
 * @method DateTimeInterface|null getRegisteredAt()
 * @method $this setRegisteredAt(?DateTimeInterface $registeredAt)
 * @method DateTimeInterface|null getIncorporatedAt()
 * @method $this setIncorporatedAt(?DateTimeInterface $incorporatedAt)
 * @method ContactPerson[] getContactPersons()
 * @method $this setContactPersons(ContactPerson[] $contactPersons)
 * @method BusinessIdentifier[] getBusinessIdentifiers()
 * @method $this setBusinessIdentifiers(BusinessIdentifier[] $businessIdentifiers)
 * @method Address getBusinessAddress()
 * @method $this setBusinessAddress(Address $businessAddress)
 * @method array|null getCustomData()
 * @method $this setCustomData(array $customData)
 * @method DateTimeInterface|null getCreatedAt()
 * @method DateTimeInterface|null getUpdatedAt()
 * @method int|null getMaxDaysPastDue()
 */
class Buyer extends AbstractModel implements HasBuyerFieldInterface
{
    #[DefaultField]
    protected string $externalId;

    #[DefaultField]
    protected ?string $tradingName;

    #[DefaultField]
    #[Required]
    protected ?string $legalName;

    #[DefaultField]
    protected ?string $legalForm;

    #[DefaultField]
    protected ?DateTimeInterface $registeredAt;

    #[DefaultField]
    protected ?DateTimeInterface $incorporatedAt;

    #[ListField(expectedItemClass: ContactPerson::class)]
    protected ?array $contactPersons = [];

    #[ListField(expectedItemClass: BusinessIdentifier::class)]
    protected ?array $businessIdentifiers;

    #[DefaultField]
    #[Required]
    protected ?Address $businessAddress;

    #[DefaultField]
    protected ?array $customData;

    #[DefaultField]
    protected ?DateTimeInterface $createdAt;

    #[DefaultField]
    protected ?DateTimeInterface $updatedAt;

    #[DefaultField]
    protected ?int $maxDaysPastDue;

    /**
     * @internal
     */
    public function getBuyerExternalId(): string
    {
        return $this->getExternalId();
    }
}
