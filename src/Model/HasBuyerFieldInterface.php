<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

/**
 * @internal is used for exception handling
 */
interface HasBuyerFieldInterface
{
    public function getBuyerExternalId(): string;
}
