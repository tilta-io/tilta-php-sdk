<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request;

use Tilta\Sdk\Model\Request\ListRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class ListRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new ListRequestModel())
            ->setLimit(500)
            ->setOffset(2)
            ->toArray();

        static::assertIsArray($data);
        static::assertCount(2, $data);
        static::assertValueShouldBeInData(500, $data, 'limit');
        static::assertValueShouldBeInData(2, $data, 'offset');
    }

    public function testNotGivenValues(): void
    {
        $data = (new ListRequestModel())->toArray();

        static::assertIsArray($data);
        static::assertCount(0, $data, 'if no query params has been given, the request-data should be empty');
    }

    public function testOneGivenValue(): void
    {
        $data = (new ListRequestModel())
            ->setLimit(100)
            ->toArray();

        static::assertIsArray($data);
        static::assertCount(1, $data);
        static::assertValueShouldBeInData(100, $data, 'limit');
    }
}
