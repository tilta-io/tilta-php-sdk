<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Order;

use Tilta\Sdk\Model\HasMerchantFieldInterface;
use Tilta\Sdk\Model\Request\ListRequestModel;

/**
 * @method string|null getPaymentMethod()
 * @method $this setPaymentMethod(?string $paymentMethod)
 * @method string|null getPaymentTerm()
 * @method $this setPaymentTerm(?string $paymentTerm)
 * @method $this setMerchantExternalId(?string $merchantExternalId)
 */
class GetOrderListRequestModel extends ListRequestModel implements HasMerchantFieldInterface
{
    protected ?string $paymentMethod = null;

    protected ?string $paymentTerm = null;

    protected ?string $merchantExternalId = null;

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
