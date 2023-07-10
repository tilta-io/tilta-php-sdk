<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\SepaMandate;

use Tilta\Sdk\Model\Request\SepaMandate\GetSepaMandateListRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetSepaMandateListRequestModelTest extends AbstractModelTestCase
{
    public function testDataFromModel(): void
    {
        $model = (new GetSepaMandateListRequestModel('buyer-id'));

        $data = $model->toArray();

        self::assertEquals([], $data, 'the model should return an empty array.');
        static::assertEquals('buyer-id', $model->getBuyerExternalId());
    }
}
