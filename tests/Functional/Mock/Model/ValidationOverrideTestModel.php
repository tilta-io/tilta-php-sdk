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
use Tilta\Sdk\Model\Request\AbstractRequestModel;

class ValidationOverrideTestModel extends AbstractRequestModel
{
    #[DefaultField]
    protected string $requiredField;

    #[DefaultField]
    protected ?string $notRequiredField = null;
}
