<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response;

use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\AbstractModel;

/**
 * @template T of AbstractModel
 * @method int getLimit()
 * @method int getOffset()
 * @method int getTotal()
 */
abstract class ListResponseModel extends AbstractResponseModel
{
    #[DefaultField]
    protected int $limit;

    #[DefaultField]
    protected int $offset;

    #[DefaultField]
    protected int $total;

    /**
     * @var T[]
     */
    #[DefaultField]
    #[ListField]
    protected array $items = [];

    /**
     * @return T[]
     */
    public function getItems(): array
    {
        // this method is a workaround, so we can use the `T` template in php-doc, and DEVs can use the code-completion
        /** @phpstan-ignore-next-line */
        return parent::__call(__FUNCTION__);
    }
}
