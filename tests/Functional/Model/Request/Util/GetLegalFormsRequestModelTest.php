<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Util;

use Tilta\Sdk\Model\Request\Util\GetLegalFormsRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetLegalFormsRequestModelTest extends AbstractModelTestCase
{
    public function testDefault(): void
    {
        $model = new GetLegalFormsRequestModel('DE');
        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(0, $data);
        static::assertEquals('DE', $model->getCountryCode());
    }
}
