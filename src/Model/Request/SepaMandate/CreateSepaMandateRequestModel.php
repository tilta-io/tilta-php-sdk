<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\SepaMandate;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\HasBuyerFieldInterface;
use Tilta\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method string getIban()
 * @method $this setIban(string $iban)
 */
class CreateSepaMandateRequestModel extends AbstractRequestModel implements HasBuyerFieldInterface
{
    #[DefaultField]
    protected string $iban;

    public function __construct(
        private readonly string $buyerExternalId
    ) {
        parent::__construct();
    }

    public function getBuyerExternalId(): string
    {
        return $this->buyerExternalId;
    }

    /**
     * @deprecated
     */
    public function setBuyerExternalId(mixed $buyerExternalId): self
    {
        return $this;
    }
}
