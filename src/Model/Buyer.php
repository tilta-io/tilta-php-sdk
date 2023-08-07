<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use DateTimeInterface;
use Tilta\Sdk\Util\ResponseHelper;
use Tilta\Sdk\Util\Validation;

/**
 * @method string getExternalId()
 * @method $this setExternalId(string $externalId)
 * @method string|null getTradingName()
 * @method $this setTradingName(?string $tradingName)
 * @method string|null getLegalName()
 * @method $this setLegalName(?string $legalName)
 * @method string|null getLegalForm()
 * @method $this setLegalForm(?string $legalForm)
 * @method DateTimeInterface getRegisteredAt()
 * @method $this setRegisteredAt(DateTimeInterface $registeredAt)
 * @method DateTimeInterface|null getIncorporatedAt()
 * @method $this setIncorporatedAt(?DateTimeInterface $incorporatedAt)
 * @method BuyerRepresentative[] getRepresentatives()
 * @method $this setRepresentatives(BuyerRepresentative[] $representatives)
 * @method Address getBusinessAddress()
 * @method $this setBusinessAddress(Address $businessAddress)
 * @method array getCustomData()
 * @method $this setCustomData(array $customData)
 */
class Buyer extends AbstractModel implements HasBuyerFieldInterface
{
    protected string $externalId;

    protected ?string $tradingName = null;

    protected ?string $legalName = null;

    protected ?string $legalForm = null;

    protected ?DateTimeInterface $registeredAt = null;

    protected ?DateTimeInterface $incorporatedAt = null;

    /**
     * @var BuyerRepresentative[]|null
     */
    protected ?array $representatives = [];

    protected ?Address $businessAddress = null;

    protected ?array $customData = [];

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
            'representatives' => static fn (string $key): array => ResponseHelper::getArray($data, $key, BuyerRepresentative::class) ?? [],
        ];
    }

    protected function getFieldValidations(): array
    {
        return [
            'representatives' => BuyerRepresentative::class . '[]',
            // we added these validations, so we can remove the validation for UpdateBuyerRequest.
            // we are using IS_REQUIRED-flag for this, so we do not need to redefine the types again (defined as typed property)
            'customData' => Validation::IS_REQUIRED,
            'businessAddress' => Validation::IS_REQUIRED,
            'registeredAt' => Validation::IS_REQUIRED,
        ];
    }
}
