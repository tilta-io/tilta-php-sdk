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
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method string getExternalId()
 * @method self setExternalId(string $externalId)
 * @method string|null getTradingName()
 * @method self setTradingName(?string $tradingName)
 * @method string|null getLegalName()
 * @method self setLegalName(?string $legalName)
 * @method string|null getLegalForm()
 * @method self setLegalForm(?string $legalForm)
 * @method DateTime getRegisteredAt()
 * @method self setRegisteredAt(DateTime $registeredAt)
 * @method DateTime|null getIncorporatedAt()
 * @method self setIncorporatedAt(?DateTime $incorporatedAt)
 * @method BuyerRepresentative[] getRepresentatives()
 * @method self setRepresentatives(BuyerRepresentative[] $representatives)
 * @method Address getBusinessAddress()
 * @method self setBusinessAddress(Address $businessAddress)
 * @method array getCustomData()
 * @method self setCustomData(array $customData)
 */
class Buyer extends AbstractModel
{
    protected string $externalId;

    protected ?string $tradingName = null;

    protected ?string $legalName = null;

    protected ?string $legalForm = null;

    protected DateTime $registeredAt;

    protected ?DateTime $incorporatedAt = null;

    /**
     * @var BuyerRepresentative[]
     */
    protected array $representatives = [];

    protected Address $businessAddress;

    protected array $customData = [];

    public function fromArray(array $data): AbstractModel
    {
        $this->externalId = ResponseHelper::getStringNN($data, 'external_id');
        $this->tradingName = ResponseHelper::getString($data, 'trading_name');
        $this->legalName = ResponseHelper::getString($data, 'legal_name');
        $this->legalForm = ResponseHelper::getString($data, 'legal_form');
        $this->registeredAt = ResponseHelper::getDateTimeNN($data, 'registered_at', 'U');
        $this->incorporatedAt = ResponseHelper::getDateTime($data, 'incorporated_at', 'U');
        $this->representatives = ResponseHelper::getArray($data, 'representatives', BuyerRepresentative::class) ?? [];
        $this->businessAddress = ResponseHelper::getObjectNN($data, 'business_address', Address::class);
        $this->customData = ResponseHelper::getArray($data, 'custom_data') ?? [];

        return $this;
    }

    protected function _toArray(): array
    {
        $data = parent::_toArray();

        $data['registered_at'] = $data['registered_at'] instanceof DateTime ? $data['registered_at']->getTimestamp() : null;
        $data['incorporated_at'] = $data['incorporated_at'] instanceof DateTime ? $data['incorporated_at']->getTimestamp() : null;

        return $data;
    }
}
