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
    public function __construct(string $externalMerchantId)
    {
        parent::__construct([], false);
        $this->setExternalId($externalMerchantId);

        $this->setCustomData(null);
        $this->setContactPersons(null);
    }

    protected function prepareValuesForGateway(array $data): array
    {
        unset($data['externalId']); // got submitted via URL parameter
        $data = $this->removeEmptyFields($data);
        return parent::prepareValuesForGateway($data);
    }

    protected function getFieldValidations(): array
    {
        $validations = parent::getFieldValidations();

        // do not unset validation for contactPersons, because type-validation in array
        unset($validations['registeredAt'], $validations['businessAddress'], $validations['customData'], $validations['legalName']);

        return $validations;
    }

    private function removeEmptyFields(array $data): array
    {
        $data = array_filter($data, static fn ($value): bool => $value !== null);

        return array_map(fn ($_data) => is_array($_data) ? $this->removeEmptyFields($_data) : $_data, $data);
    }
}
