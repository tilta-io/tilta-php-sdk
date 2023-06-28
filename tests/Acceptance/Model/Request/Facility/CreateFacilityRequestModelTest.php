<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Facility;

use Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateFacilityRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new CreateFacilityRequestModel('external-id'));
        $outputData = $model->toArray();

        $this->assertIsArray($outputData);
        $this->assertEquals([], $outputData, 'model should return an empty array, cause the external-id is a path parameter');
        $this->assertEquals('external-id', $model->getExternalId());
    }
}