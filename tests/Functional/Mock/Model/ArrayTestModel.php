<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Mock\Model;

use DateTime;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @method int getIntValue()
 * @method int|null getNullableIntValue()
 * @method float getFloatValue()
 * @method float|null getNullableFloatValue()
 * @method string getStringValue()
 * @method string|null getNullableStringValue()
 * @method bool getBoolValue()
 * @method DateTime getDateBySeconds()
 * @method DateTime getNullableDateBySeconds()
 * @method SimpleTestModel getObjectValue()
 * @method ArrayTestModel|null getNullableObjectValue()
 * @method array getSimpleArrayValue()
 * @method SimpleTestModel[] getArrayWithObjectValue()
 */
class ArrayTestModel extends AbstractModel
{
    protected DateTime $dateBySeconds;

    protected ?DateTime $nullableDateBySeconds = null;

    protected int $intValue;

    protected ?int $nullableIntValue = null;

    protected float $floatValue;

    protected ?float $nullableFloatValue = null;

    protected string $stringValue;

    protected ?string $nullableStringValue = null;

    protected bool $boolValue;

    protected SimpleTestModel $objectValue;

    protected ?ArrayTestModel $nullableObjectValue = null;

    protected array $simpleArrayValue = [];

    protected array $arrayWithObjectValue = [];

    protected function prepareModelData(array $data): array
    {
        return [
            'arrayWithObjectValue' => static fn (string $key): array => ResponseHelper::getArray($data, $key, SimpleTestModel::class) ?? [],
        ];
    }
}
