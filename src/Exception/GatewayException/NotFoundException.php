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
    protected ?string $externalId;

    protected static ?string $entityName = null;

    public function __construct(string $externalId = null, int $httpCode = 404, array $responseData = [], array $requestData = [])
    {
        $this->externalId = $externalId;
        parent::__construct($httpCode, $responseData, $requestData);
    }

    final public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    final public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
        $this->message = $this->getErrorMessage();
    }

    protected function getErrorMessage(): string
    {
        $message = parent::getErrorMessage();

        if ($message === '' && $this->externalId !== null) {
            if (static::$entityName !== null) {
                return sprintf('%s with external_id `%s` does not exist.', static::$entityName, $this->externalId);
            }

            return sprintf('The entity with the external_id `%s` does not exist.', $this->externalId);
        }

        return $message;
    }
}
