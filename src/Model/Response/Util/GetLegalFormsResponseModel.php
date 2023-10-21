<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Util;

use Tilta\Sdk\Exception\InvalidResponseException;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

class GetLegalFormsResponseModel extends AbstractResponseModel
{
    private array $items = [];

    public function fromArray(array $data): self
    {
        // this is not the best way to implement this response(-model).
        // But we want to keep the response very clean without many objects

        if ($data !== []
            && (
                (function_exists('array_is_list') && !array_is_list($data)) // only PHP > 8.1
                || array_keys($data) !== range(0, count($data) - 1)
            )
        ) {
            throw new InvalidResponseException('An list response was expected. It seems like that an object has been returned.');
        }

        foreach ($data as $item) {
            if (!isset($item['name'], $item['displayName'])) {
                throw new InvalidResponseException('An list with item-keys `name`, `displayName` was expected. Got keys: ' . implode(', ', array_keys($item)));
            }

            $this->items[$item['name']] = $item['displayName'];
        }

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getDisplayName(string $code): ?string
    {
        return $this->items[$code] ?? null;
    }
}
