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
use Tilta\Sdk\Model\Request\CustomDataTrait;
use Tilta\Sdk\Util\ResponseHelper;
use Tilta\Sdk\Util\Validation;

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
 * @method string|null getTaxId()
 * @method $this setTaxId(?string $taxId)
 */
class Buyer extends AbstractModel implements HasBuyerFieldInterface
{
    use CustomDataTrait;

    protected string $externalId;

    protected ?string $tradingName = null;

    protected ?string $legalName = null;

    protected ?string $legalForm = null;

    protected ?DateTimeInterface $registeredAt = null;

    protected ?DateTimeInterface $incorporatedAt = null;

    /**
     * @var ContactPerson[]|null
     */
    protected ?array $contactPersons = [];

    protected ?Address $businessAddress = null;

    protected ?string $taxId = null;

    /**
     * @internal
     */
    public function getBuyerExternalId(): string
    {
        return $this->getExternalId();
    }

    protected function prepareValuesForGateway(array $data): array
    {
        if (isset($data['customData']) && $data['customData'] === []) {
            $data['customData'] = null;
        }

        return parent::prepareValuesForGateway($data);
    }

    protected function prepareModelData(array $data): array
    {
        return [
            'contactPersons' => static fn (string $key): array => ResponseHelper::getArray($data, $key, ContactPerson::class) ?? [],
        ];
    }

    protected function getFieldValidations(): array
    {
        return [
            'contactPersons' => '?' . ContactPerson::class . '[]',
            // we added these validations, so we can remove the validation for UpdateBuyerRequest.
            // we are using IS_REQUIRED-flag for this, so we do not need to redefine the types again (defined as typed property)
            'customData' => Validation::IS_REQUIRED,
            'businessAddress' => Validation::IS_REQUIRED,
            'registeredAt' => Validation::IS_REQUIRED,
            'legalName' => Validation::IS_REQUIRED,
        ];
    }
}
