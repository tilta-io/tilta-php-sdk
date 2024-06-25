<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Order;

use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Request\RequestModelInterface;

/**
 * @method string getName()
 * @method $this setName(string $name)
 * @method string getDataType()
 * @method $this setDataType(string $dataType)
 * @method string|null getDescription()
 * @method $this setDescription(string $description)
 */
class CustomDataAttribute extends AbstractModel implements RequestModelInterface
{
    public const DATA_TYPE_STRING = 'STRING';

    public const DATA_TYPE_BOOLEAN = 'BOOLEAN';

    public const DATA_TYPE_FLOAT = 'NUMBER';

    protected string $name;

    protected string $dataType;

    protected ?string $description = null;
}
