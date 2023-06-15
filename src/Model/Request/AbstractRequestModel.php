<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request;

use BadMethodCallException;
use Tilta\Sdk\Model\AbstractModel;

abstract class AbstractRequestModel extends AbstractModel implements RequestModelInterface
{
    public function __construct()
    {
        parent::__construct([], false);
    }

    public function fromArray(array $data): self
    {
        throw new BadMethodCallException('the method `fromArray` is not allowed on the model ' . static::class);
    }
}
