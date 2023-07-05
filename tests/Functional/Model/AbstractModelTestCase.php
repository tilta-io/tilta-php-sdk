<?php
/*
 * Copyright (c) Tilta Fintech GmbH
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
        if (strpos($originalClassName, 'Tilta\Sdk\Model\\') === 0) {
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

    /**
     * @param mixed $expected
     */
    protected static function assertValueShouldBeInData($expected, array $data, string $key): void
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
