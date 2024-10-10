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
 * @method string|null getObjectKey1()
 * @method string|null getObjectKey2()
 * @method ResponseHelperModelMock|null getSubObject()
 */
class ResponseHelperModelMock extends AbstractModel
{
    #[DefaultField('key1')]
    protected ?string $objectKey1 = null;

    #[DefaultField('key2')]
    protected ?string $objectKey2 = null;

    #[DefaultField('sub')]
    protected ?ResponseHelperModelMock $subObject = null;
}
