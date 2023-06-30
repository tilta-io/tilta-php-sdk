<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Mock\Model;

use Tilta\Sdk\Model\AbstractModel;

/**
 * @method $this setFieldValue(string $fieldValue)
 * @method string getFieldValue()
 * @method $this setNullableFieldValue(?string $nullableFieldValue)
 * @method string|null getNullableFieldValue()
 */
class SimpleTestModel extends AbstractModel
{
    protected string $fieldValue = 'default value';

    protected ?string $nullableFieldValue = null;
}
