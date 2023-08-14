<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request;

/**
 * @method int|null getLimit()
 * @method $this setLimit(?int $limit)
 * @method int|null getOffset()
 * @method $this setOffset(?int $offset)
 */
class ListRequestModel extends AbstractRequestModel
{
    protected ?int $limit = null;

    protected ?int $offset = null;

    protected function _toArray(): array
    {
        $data = parent::_toArray();

        // if a property is null, the parameter should not be given.
        return array_filter($data, static fn ($value): bool => $value !== null);
    }
}
