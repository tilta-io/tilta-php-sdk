<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model;

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
    protected string $currency;

    protected int $gross;

    protected int $net;

    /**
     * value is not required on API endpoints. we set it to 0, because NULL would me 0.
     */
    protected ?int $tax = 0;
}
