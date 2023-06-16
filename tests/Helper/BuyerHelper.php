<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Helper;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\BuyerRepresentative;

class BuyerHelper
{
    /**
     * @template T of Buyer
     * @param class-string<T> $class
     * @return T
     */
    public static function createValidBuyer(string $externalId, string $class): Buyer
    {
        /** @phpstan-ignore-next-line */
        return self::fillUpBuyerObject(new $class(), $externalId);
    }

    public static function fillUpBuyerObject(Buyer $buyer, string $externalId = null): Buyer
    {
        if ($externalId !== null) {
            $buyer->setExternalId($externalId);
        }

        $address = (new Address())
            ->setStreet('Teststreet')
            ->setHouseNumber('123')
            ->setPostcode('12345')
            ->setCity('Testcity')
            ->setCountry('DE')
            ->setAdditional('room 200');

        return $buyer
            ->setTradingName(sprintf('My Trading Name (Unit-Test %s) ', $externalId))
            ->setLegalName(sprintf('My Legal Name (Unit-Test %s) ', $externalId))
            ->setLegalForm('GMBH')
            ->setRegisteredAt((new DateTime())->setTimestamp(time() - 3600))
            ->setIncorporatedAt((new DateTime())->setTimestamp(time() - 3600))
            ->setRepresentatives([
                (new BuyerRepresentative())
                    ->setSalutation('MR')
                    ->setFirstName('Firstname')
                    ->setLastName('Lastname')
                    ->setBirthDate((new DateTime())->setDate(2000, 1, 1))
                    ->setEmail('cto@of-company.net')
                    ->setPhone('0123456789')
                    ->setAddress($address),
            ])
            ->setBusinessAddress($address)
            ->setCustomData([
                'source' => 'phpunit',
            ]);
    }
}
