<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Helper;

use DateTime;
use Tilta\Sdk\Model\Address;
use Tilta\Sdk\Model\Buyer;
use Tilta\Sdk\Model\ContactPerson;
use Tilta\Sdk\Model\Request\Buyer\CreateBuyerRequestModel;
use Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel;
use Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest;
use Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest;

class BuyerHelper extends AbstractHelper
{
    /**
     * @template T of Buyer
     * @param class-string<T> $class
     * @return T
     */
    public static function createValidBuyer(string $externalId, string $class = Buyer::class): Buyer
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
            ->setStreet('Linienstrasse')
            ->setHouseNumber('222')
            ->setPostcode('10119')
            ->setCity('Berlin')
            ->setCountry('DE')
            ->setAdditional('room 200');

        return $buyer
            ->setTradingName('Ultramarathon GmbH')
            ->setLegalName('Ultramarathon GmbH')
            ->setLegalForm('DE_GMBH')
            ->setTaxId('DE123456')
            ->setRegisteredAt((new DateTime())->setTimestamp(time() - 3600))
            ->setIncorporatedAt((new DateTime())->setTimestamp(time() - 3600))
            ->setContactPersons([
                (new ContactPerson())
                    ->setSalutation('MR')
                    ->setFirstName('Firstname')
                    ->setLastName('Lastname')
                    ->setBirthDate((new DateTime())->setDate(2000, 1, 1))
                    ->setEmail('cto@of-company.net')
                    ->setPhone('+491741123334')
                    ->setAddress($address),
            ])
            ->setBusinessAddress($address)
            ->setCustomData([
                'source' => 'phpunit',
            ]);
    }

    public static function createUniqueExternalId(string $testName, string $prefixCacheKey = null): string
    {
        return parent::createUniqueExternalId($testName, $prefixCacheKey) . '-buyer';
    }

    public static function getBuyerExternalIdWithValidFacility(string $testName): string
    {
        $testBuyerId = getenv('TILTA_TEST_BUYER');
        if ($testBuyerId === '' || $testBuyerId === false) {
            $client = TiltaClientHelper::getClient();
            $buyer = self::createValidBuyer(self::createUniqueExternalId($testName), CreateBuyerRequestModel::class);
            (new CreateBuyerRequest($client))->execute($buyer);
            (new CreateFacilityRequest($client))->execute((new CreateFacilityRequestModel($buyer->getExternalId())));
            sleep(1);

            return $buyer->getBuyerExternalId();
        }

        return $testBuyerId;
    }
}
