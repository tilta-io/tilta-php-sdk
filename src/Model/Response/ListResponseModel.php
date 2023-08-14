<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response;

use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Util\ResponseHelper;

/**
 * @template T of AbstractModel
 * @method int getLimit()
 * @method int getOffset()
 * @method int getTotal()
 */
class ListResponseModel extends AbstractResponseModel
{
    protected int $limit;

    protected int $offset;

    protected int $total;

    /**
     * @var T[]
     */
    protected array $items = [];

    private string $modelClass;

    public function __construct(string $modelClass, array $data = [])
    {
        $this->modelClass = $modelClass;
        parent::__construct($data);
    }

    /**
     * @return T[]
     */
    public function getItems(): array
    {
        // this method is a workaround, so we can use the `T` template in php-doc, and DEVs can use the code-completion
        /** @phpstan-ignore-next-line */
        return parent::__call(__FUNCTION__);
    }

    protected function prepareModelData(array $data): array
    {
        return [
            'items' => fn ($key): ?array => ResponseHelper::getArray($data, $key, $this->modelClass),
        ];
    }
}
