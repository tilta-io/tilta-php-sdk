<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Service\Request\Facility;

use PHPUnit\Framework\TestCase;

class GetFacilityRequestTest extends TestCase
{
    public function testNothing(): void
    {
        // this class is just for completion.
        // the testCase CreateFacilityRequestTest also tests the get-facility. so we do not to implement create-buyer, create-facility and get-facility in this test-case (again)
        $this->assertTrue(true);
    }
}
