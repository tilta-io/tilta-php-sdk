<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Tests\Functional\Mock\Model;

use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @method int getIntValue()
 * @method int|null getNullableIntValue()
 * @method float getFloatValue()
 * @method float|null getNullableFloatValue()
 * @method string getStringValue()
 * @method string|null getNullableStringValue()
 * @method bool getBoolValue()
 * @method DateTimeInterface getDateBySeconds()
 * @method DateTimeInterface getNullableDateBySeconds()
 * @method SimpleTestModel getObjectValue()
 * @method ArrayTestModel|null getNullableObjectValue()
 * @method array getSimpleArrayValue()
 * @method SimpleTestModel[] getArrayWithObjectValue()
 */
class ArrayTestModel extends AbstractModel
{
    #[DefaultField]
    protected DateTimeInterface $dateBySeconds;

    #[DefaultField]
    protected ?DateTimeInterface $nullableDateBySeconds = null;

    #[DefaultField]
    protected int $intValue;

    #[DefaultField]
    protected ?int $nullableIntValue = null;

    #[DefaultField]
    protected float $floatValue;

    #[DefaultField]
    protected ?float $nullableFloatValue = null;

    #[DefaultField]
    protected string $stringValue;

    #[DefaultField]
    protected ?string $nullableStringValue = null;

    #[DefaultField]
    protected bool $boolValue;

    #[DefaultField]
    protected SimpleTestModel $objectValue;

    #[DefaultField]
    protected ?ArrayTestModel $nullableObjectValue = null;

    #[DefaultField]
    protected array $simpleArrayValue = [];

    #[ListField(expectedItemClass: SimpleTestModel::class)]
    protected array $arrayWithObjectValue = [];
}
