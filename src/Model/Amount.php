<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

use Tilta\Sdk\Attributes\ApiField\DefaultField;

/**
 * @method string getCurrency()
 * @method $this setCurrency(string $currency)
 * @method int getGross()
 * @method $this setGross(int $gross)
 * @method int getNet()
 * @method $this setNet(int $net)
 * @method int getTax()
 * @method $this setTax(int $tax)
 */
class Amount extends AbstractModel
{
    #[DefaultField]
    protected string $currency;

    #[DefaultField]
    protected int $gross;

    #[DefaultField]
    protected int $net;

    #[DefaultField]
    protected ?int $tax;
}
