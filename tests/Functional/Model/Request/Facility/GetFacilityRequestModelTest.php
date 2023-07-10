<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Request\Facility;

use Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class GetFacilityRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new GetFacilityRequestModel('buyer-external-id'));
        $outputData = $model->toArray();

        self::assertIsArray($outputData);
        self::assertEquals([], $outputData, 'model should return an empty array, cause the external-id is a path parameter');
        self::assertEquals('buyer-external-id', $model->getBuyerExternalId());
    }
}
