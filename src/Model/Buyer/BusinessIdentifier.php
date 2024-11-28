<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Buyer;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @method string getType()
 * @method $this setType(string $type)
 * @method string getValue()
 * @method $this setValue(string $value)
 * @method string getCountry()
 * @method $this setCountry(string $country)
 */
class BusinessIdentifier extends AbstractModel
{
    final public const TYPE_VAT_ID = 'VAT_ID';

    final public const TYPE_TAX_ID = 'TAX_ID';

    final public const TYPE_COURT_ID = 'COURT_ID';

    #[DefaultField]
    protected string $type;

    #[DefaultField]
    protected string $value;

    #[DefaultField]
    protected string $country;
}
