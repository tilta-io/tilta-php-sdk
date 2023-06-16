<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Buyer;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\BuyerRepresentative;
use Tilta\Sdk\Model\Request\EntityRequestModelInterface;

/**
 * @method DateTime|null getRegisteredAt()
 * @method self setRegisteredAt(?DateTime $registeredAt)
 * @method BuyerRepresentative[]|null getRepresentatives()
 * @method self setRepresentatives(?BuyerRepresentative[] $representatives)
 * @method Address|null getBusinessAddress()
 * @method self setBusinessAddress(?Address $businessAddress)
 * @method array|null getCustomData()
 * @method self setCustomData(?array $customData)
 */
class UpdateBuyerRequestModel extends Buyer implements EntityRequestModelInterface
{
    public function __construct(string $externalMerchantId)
    {
        parent::__construct([], false);
        $this->setExternalId($externalMerchantId);

        $this->setCustomData(null);
        $this->setRepresentatives(null);
    }

    public function getExternalId(): string
    {
        return $this->externalId;
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

        $validations['representatives'] = '?' . $validations['representatives']; // do not unset validation, because type-validation in array
        unset($validations['registeredAt'], $validations['businessAddress'], $validations['customData']);

        return $validations;
    }

    private function removeEmptyFields(array $data): array
    {
        $data = array_filter($data, static fn ($value): bool => $value !== null);

        return array_map(fn ($_data) => is_array($_data) ? $this->removeEmptyFields($_data) : $_data, $data);
    }
}
