<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request;

use Tilta\Sdk\Model\HasBuyerFieldInterface;

abstract class AbstractBuyerRequestModel extends AbstractRequestModel implements HasBuyerFieldInterface
{
    protected string $externalBuyerId;

    public function __construct(string $externalBuyerId)
    {
        parent::__construct();
        $this->externalBuyerId = $externalBuyerId;
    }

    public function getBuyerExternalId(): string
    {
        return $this->externalBuyerId;
    }
}
