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
use Tilta\Sdk\Attributes\ApiField\DefaultField;
use Tilta\Sdk\Attributes\ApiField\ListField;
use Tilta\Sdk\Model\Response\Facility\FacilityPendingAction;

/**
 * @method string getStatus()
 * @method DateTimeInterface|null getReviewedAt()
 * @method string getCurrency()
 * @method int getTotalAmount()
 * @method int getAvailableAmount()
 * @method int getUsedAmount()
 * @method string|null getRiskBand()
 * @method DateTimeInterface|null getCreatedAt()
 * @method DateTimeInterface|null getUpdatedAt()
 * @method FacilityPendingAction[]|null getPendingActions()
 */
class Facility extends AbstractResponseModel
{
    #[DefaultField]
    protected string $status;

    #[DefaultField]
    protected ?DateTimeInterface $reviewedAt;

    #[DefaultField]
    protected string $currency;

    #[DefaultField]
    protected int $totalAmount;

    #[DefaultField]
    protected int $availableAmount;

    #[DefaultField]
    protected int $usedAmount;

    #[DefaultField]
    protected ?string $riskBand;

    #[DefaultField]
    protected ?DateTimeInterface $createdAt;

    #[DefaultField]
    protected ?DateTimeInterface $updatedAt;

    #[ListField(expectedItemClass: FacilityPendingAction::class)]
    protected ?array $pendingActions;
}
