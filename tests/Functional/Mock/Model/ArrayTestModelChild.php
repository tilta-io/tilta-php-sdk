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
 * @method string getFieldValue()
 */
class ArrayTestModelChild extends AbstractModel
{
    protected string $fieldValue;
}
