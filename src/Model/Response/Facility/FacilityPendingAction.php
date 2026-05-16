<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Model\Response\Facility;

use DateTimeInterface;
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Model\Response\AbstractResponseModel;

/**
 * @method string getType()
 * @method DateTimeInterface getCreatedAt()
 */
class FacilityPendingAction extends AbstractResponseModel
{
    #[DefaultField]
    protected string $type;

    #[DefaultField]
    protected DateTimeInterface $createdAt;
}
