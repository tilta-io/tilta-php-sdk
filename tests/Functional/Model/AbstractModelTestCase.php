<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Util\ResponseHelper;

abstract class AbstractModelTestCase extends TestCase
{
    protected function createMock(string $originalClassName): MockObject
    {
        $mock = parent::createMock($originalClassName);
        if (str_starts_with($originalClassName, 'Tilta\Sdk\Model\\')) {
            $mock->method('toArray')->willReturn([]);
            $mock->method('validateFields');
        }

        return $mock;
    }

    protected static function assertInputOutputModel(array $inputData, AbstractModel $model): void
    {
        $inputData = self::replacePHPUnitArrays($inputData);
        $outputData = self::replacePHPUnitArrays($model->toArray());
        // sort array to make sure they are in the same order
        ksort($inputData);
        ksort($outputData);

        static::assertEquals($inputData, $outputData);
    }

    protected static function assertValueShouldBeInData(mixed $expected, array $data, string $key): void
    {
        static::assertArrayHasKey($key, $data);
        static::assertEquals($expected, $data[$key]);
    }

    private static function replacePHPUnitArrays(array $array): array
    {
        if ($array === ResponseHelper::PHPUNIT_OBJECT) {
            return [];
        }

        foreach ($array as $k => $v) {
            $array[$k] = is_array($v) ? self::replacePHPUnitArrays($v) : $v;
        }

        return $array;
    }
}
