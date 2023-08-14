<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\SepaMandate;

use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\Request\ListRequestModel;

/**
 * @method $this setBuyerExternalId(string $buyerExternalId)
 */
class GetSepaMandateListRequestModel extends ListRequestModel implements HasBuyerFieldInterface
{
    protected string $buyerExternalId;

    protected static array $_additionalFieldMapping = [
        'buyerExternalId' => false,
    ];

    public function __construct(string $buyerExternalId)
    {
        parent::__construct();
        $this->buyerExternalId = $buyerExternalId;
    }

    public function getBuyerExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
