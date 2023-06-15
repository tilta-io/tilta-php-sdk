<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request;

/**
 * @method int|null getLimit()
 * @method self setLimit(?int $limit)
 * @method int|null getOffset()
 * @method self setOffset(?int $offset)
 */
class ListRequestModel extends AbstractRequestModel
{
    protected ?int $limit = null;

    protected ?int $offset = null;

    protected function _toArray(): array
    {
        $data = parent::_toArray();

        return array_filter($data, static fn ($value): bool => $value !== null);
    }
}
