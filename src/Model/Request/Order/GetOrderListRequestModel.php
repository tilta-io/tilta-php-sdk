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
    #[DefaultField]
    protected ?string $paymentMethod = null;

    #[DefaultField]
    protected ?string $paymentTerm = null;

    #[DefaultField]
    protected ?string $merchantExternalId = null;

    public function getMerchantExternalId(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->__call(__FUNCTION__);
    }
}
