<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model\Request;

use Tilta\Sdk\Model\Request\ListRequestModel;
use Tilta\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class ListRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new ListRequestModel())
            ->setLimit(500)
            ->setOffset(2)
            ->toArray();

        $this->assertIsArray($data);
        $this->assertCount(2, $data);
        $this->assertEquals(500, $data['limit']);
        $this->assertEquals(2, $data['offset']);
    }
}
