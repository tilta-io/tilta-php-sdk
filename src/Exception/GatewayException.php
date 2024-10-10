<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Exception;

class GatewayException extends TiltaException
{
    protected static string $defaultErrorCode = '';

    protected static ?string $defaultErrorMessage = null;

    public function __construct(
        private readonly int $httpCode,
        private readonly array $responseData = [],
        private readonly array $requestData = []
    ) {
        parent::__construct($this->getErrorMessage(), self::$defaultErrorCode);
    }

    public function getResponseData(): array
    {
        return $this->responseData;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getTiltaCode(): string
    {
        return $this->responseData['code'] ?? $this->tiltaCode;
    }

    protected function getErrorMessage(): string
    {
        return $this->responseData['message'] ?? $this->responseData['error'] ?? static::$defaultErrorMessage ?? '';
    }
}
