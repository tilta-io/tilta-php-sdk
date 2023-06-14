<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Acceptance\Model;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class AbstractModelTestCase extends TestCase
{
    protected function createMock(string $originalClassName): MockObject
    {
        $mock = parent::createMock($originalClassName);
        if (strpos($originalClassName, 'Tilta\Sdk\Model\\') === 0) {
            $mock->method('toArray')->willReturn([]);
            $mock->method('validateFields');
        }

        return $mock;
    }
}
