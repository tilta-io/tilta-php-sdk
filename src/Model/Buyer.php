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

    protected function prepareModelData(array $data): array
    {
        return [
            'representatives' => static fn (string $key): array => ResponseHelper::getArray($data, $key, BuyerRepresentative::class) ?? [],
        ];
    }
}
