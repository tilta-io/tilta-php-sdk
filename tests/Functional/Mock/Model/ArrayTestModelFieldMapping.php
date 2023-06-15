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
 * @method string getFieldRenamedInSdk()
 */
class ArrayTestModelFieldMapping extends AbstractModel
{
    protected static array $_additionalFieldMapping = [
        'fieldRenamedInSdk' => 'field_which_is_not_in_sdk',
    ];

    protected string $fieldRenamedInSdk;
}
