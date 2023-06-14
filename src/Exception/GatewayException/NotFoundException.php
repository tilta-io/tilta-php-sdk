<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException;

use Tilta\Sdk\Exception\GatewayException;

class NotFoundException extends GatewayException
{
    protected string $externalId;

    public function __construct(string $externalId, int $httpCode, array $responseData = [], array $requestData = [])
    {
        parent::__construct(
            $this->generateMessage($externalId),
            $httpCode,
            $responseData,
            $requestData
        );
        $this->setExternalId($externalId);
    }

    final public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getTiltaCode(): string
    {
        return 'NOT_FOUND';
    }

    final public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    protected function generateMessage(string $externalId): string
    {
        return sprintf('The entity with the external_id `%s` does not exist.', $externalId);
    }
}
