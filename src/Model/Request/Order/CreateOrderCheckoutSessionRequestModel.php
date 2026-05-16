<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Request\AbstractOrderRequestModel;

/**
 * @method string|null getSuccessUrl()
 * @method $this setSuccessUrl(?string $successUrl)
 * @method string|null getErrorUrl()
 * @method $this setErrorUrl(?string $errorUrl)
 */
class CreateOrderCheckoutSessionRequestModel extends AbstractOrderRequestModel
{
    #[DefaultField]
    protected ?string $successUrl = null;

    #[DefaultField]
    protected ?string $errorUrl = null;

    protected function _toArray(): array
    {
        $data = parent::_toArray();

        return array_filter($data, static fn ($value): bool => $value !== null);
    }
}
