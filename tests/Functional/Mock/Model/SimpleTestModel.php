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
 * @method $this setFieldValue(string $fieldValue)
 * @method string getFieldValue()
 * @method $this setNullableFieldValue(?string $nullableFieldValue)
 * @method string|null getNullableFieldValue()
 */
class SimpleTestModel extends AbstractModel
{
    #[DefaultField]
    protected string $fieldValue = 'default value';

    #[DefaultField]
    protected ?string $nullableFieldValue = null;
}
