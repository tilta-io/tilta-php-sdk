<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Buyer;

use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\ContactPerson;
use Tilta\Sdk\Model\Request\RequestModelInterface;

/**
 * @method DateTimeInterface|null getRegisteredAt()
 * @method $this setRegisteredAt(?DateTimeInterface $registeredAt)
 * @method ContactPerson[]|null getContactPersons()
 * @method $this setContactPersons(?ContactPerson[] $contactPersons)
 * @method Address|null getBusinessAddress()
 * @method $this setBusinessAddress(?Address $businessAddress)
 * @method array|null getCustomData()
 * @method $this setCustomData(?array $customData)
 */
class UpdateBuyerRequestModel extends Buyer implements RequestModelInterface
{
    // do not add DefaultField attribute. This will be passed as path-parameter
    protected string $externalId;

    #[ListField] // removed Required-Attribute
    protected ?array $customData;

    #[DefaultField] // removed Required-Attribute
    protected ?string $legalName;

    #[DefaultField] // removed Required-Attribute
    protected ?DateTimeInterface $registeredAt;

    #[DefaultField] // removed Required-Attribute
    protected ?Address $businessAddress;

    #[DefaultField] // removed default value
    protected ?array $contactPersons;

    public function __construct(string $externalMerchantId)
    {
        parent::__construct([], false);
        $this->setExternalId($externalMerchantId);
    }
}
