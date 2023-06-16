<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Service\Request\Facility;

use Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetFacilityRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new GetFacilityRequestModel('external-id'));
        $outputData = $model->toArray();

        $this->assertIsArray($outputData);
        $this->assertEquals([], $outputData, 'model should return an empty array, cause the external-id is a path parameter');
        $this->assertEquals('external-id', $model->getExternalId());
    }
}
