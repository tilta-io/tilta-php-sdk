<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception;

class GatewayException extends TiltaException
{
    private array $responseData;

    private array $requestData;

    public function __construct(string $defaultMessage, int $httpCode, array $responseData = [], array $requestData = [])
    {
        $this->responseData = $responseData;
        $this->requestData = $requestData;

        if (isset($responseData['code'], $responseData['error'])) {
            parent::__construct($responseData['error'], $responseData['code']);
        } else {
            parent::__construct($defaultMessage, (string) $httpCode);
        }
    }

    public function getResponseData(): array
    {
        return $this->responseData;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }
}
