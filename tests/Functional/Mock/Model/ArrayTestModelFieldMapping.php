<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Mock\Model;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @method string getFieldRenamedInSdk()
 */
class ArrayTestModelFieldMapping extends AbstractModel
{
    #[DefaultField(apiField: 'field_which_is_not_in_sdk')]
    protected string $fieldRenamedInSdk;
}
