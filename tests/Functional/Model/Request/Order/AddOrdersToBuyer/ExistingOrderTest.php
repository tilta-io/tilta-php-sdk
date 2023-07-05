<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Request\Order\AddOrdersToBuyer;

use BadMethodCallException;
use Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class ExistingOrderTest extends AbstractModelTestCase
{
    /**
     * @dataProvider disallowedMethods
     */
    public function testDisallowedMethods(string $method, array $arguments): void
    {
        static::expectException(BadMethodCallException::class);
        (new ExistingOrder())->{$method}(...$arguments);
    }

    public function disallowedMethods(): array
    {
        return [
            ['getBuyerExternalId', []],
            ['setBuyerExternalId', ['']],
        ];
    }
}
