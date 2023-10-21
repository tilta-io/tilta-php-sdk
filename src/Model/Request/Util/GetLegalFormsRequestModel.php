<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Request\Util;

use Tilta\Sdk\Model\Request\AbstractRequestModel;

class GetLegalFormsRequestModel extends AbstractRequestModel
{
    protected static array $_additionalFieldMapping = [
        'countryCode' => false,
    ];

    private string $countryCode;

    public function __construct(string $countryCode)
    {
        parent::__construct();
        $this->countryCode = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}
