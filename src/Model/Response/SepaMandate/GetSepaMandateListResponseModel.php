<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\SepaMandate;

use Tilta\Sdk\Model\Response\ListResponseModel;
use Tilta\Sdk\Model\Response\SepaMandate;

/**
 * @extends ListResponseModel<SepaMandate>
 */
class GetSepaMandateListResponseModel extends ListResponseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct(SepaMandate::class, $data);
    }
}
