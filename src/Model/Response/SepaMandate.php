<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response;

use DateTimeInterface;

/**
 * @method string getMandateId()
 * @method string getIban()
 * @method DateTimeInterface getCreatedAt()
 */
class SepaMandate extends AbstractResponseModel
{
    protected string $mandateId;

    protected string $iban;

    protected DateTimeInterface $createdAt;
}
