<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\Response;

use DateTime;
use Tilta\Sdk\Model\Response\SepaMandate;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class SepaMandateTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $inputData = [
            'mandate_id' => 'mandate-id',
            'iban' => 'DE1234567678234',
            'created_at' => (new DateTime())->setDate(2023, 05, 16)->getTimestamp(),
        ];
        $model = (new SepaMandate())->fromArray($inputData);

        static::assertInputOutputModel($inputData, $model);
    }
}
