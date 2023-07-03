<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Order;

use Tilta\Sdk\Model\AbstractModel;

/**
 * @method string getName()
 * @method $this setName(string $name)
 * @method string getCategory()
 * @method $this setCategory(string $category)
 * @method string|null getDescription()
 * @method $this setDescription(?string $description)
 * @method int getPrice()
 * @method $this setPrice(int $price)
 * @method string getCurrency()
 * @method $this setCurrency(string $currency)
 * @method int getQuantity()
 * @method $this setQuantity(int $quantity)
 */
class LineItem extends AbstractModel
{
    protected string $name;

    protected string $category;

    protected ?string $description = null;

    protected int $price;

    protected string $currency;

    protected int $quantity;
}
