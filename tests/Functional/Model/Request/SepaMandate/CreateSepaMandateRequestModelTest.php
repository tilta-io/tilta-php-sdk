<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Model\SepaMandate;

use Tilta\Sdk\Model\Request\SepaMandate\CreateSepaMandateRequestModel;
use Tilta\Sdk\Tests\Functional\Model\AbstractModelTestCase;

class CreateSepaMandateRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new CreateSepaMandateRequestModel('buyer-external-id'))
            ->setIban('DE12345678910111213');

        $data = $model->toArray();
        static::assertIsArray($data);
        static::assertCount(1, $data);
        static::assertArrayNotHasKey('buyer_external_id', $data); // buyer external id should not be in the array;
        static::assertValueShouldBeInData('DE12345678910111213', $data, 'iban');
    }
}
