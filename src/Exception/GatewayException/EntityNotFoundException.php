<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception\GatewayException;

abstract class EntityNotFoundException extends NotFoundException
{
    protected ?string $entityName = null;

    protected function generateMessage(string $externalId): string
    {
        return sprintf('%s with external_id `%s` does not exist.', $this->entityName ?? 'The entity', $externalId);
    }
}
