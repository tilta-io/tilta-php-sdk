<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response;

use DateTime;

/**
 * @method string getMandateId()
 * @method string getIban()
 * @method DateTime getCreatedAt()
 */
class SepaMandate extends AbstractResponseModel
{
    protected string $mandateId;

    protected string $iban;

    protected DateTime $createdAt;
}
