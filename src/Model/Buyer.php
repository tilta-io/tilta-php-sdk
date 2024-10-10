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

/**
 * @method string getExternalId()
 * @method $this setExternalId(string $externalId)
 * @method string|null getTradingName()
 * @method $this setTradingName(?string $tradingName)
 * @method string getLegalName()
 * @method $this setLegalName(string $legalName)
 * @method string|null getLegalForm()
 * @method $this setLegalForm(?string $legalForm)
 * @method DateTimeInterface getRegisteredAt()
 * @method $this setRegisteredAt(DateTimeInterface $registeredAt)
 * @method DateTimeInterface|null getIncorporatedAt()
 * @method $this setIncorporatedAt(?DateTimeInterface $incorporatedAt)
 * @method ContactPerson[] getContactPersons()
 * @method $this setContactPersons(ContactPerson[] $contactPersons)
 * @method Address getBusinessAddress()
 * @method $this setBusinessAddress(Address $businessAddress)
 * @method array getCustomData()
 * @method $this setCustomData(array $customData)
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
    #[Required]
    protected ?DateTimeInterface $registeredAt;

    #[DefaultField]
    protected ?DateTimeInterface $incorporatedAt;

    #[ListField(expectedItemClass: ContactPerson::class)]
    protected ?array $contactPersons = [];

    #[DefaultField]
    #[Required]
    protected ?Address $businessAddress;

    #[ListField]
    #[Required]
    protected ?array $customData = [];

    // field does not exist on api anymore.
    // Keep it for backward compatibility
    protected mixed $taxId;

    /**
     * @internal
     */
    public function getBuyerExternalId(): string
    {
        return $this->getExternalId();
    }
}
