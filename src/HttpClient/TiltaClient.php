<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\HttpClient;

use Exception;
use Tilta\Sdk\Exception\GatewayException\InvalidRequestException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\GatewayException\UnexpectedServerResponse;
use Tilta\Sdk\Exception\GatewayException\UserNotAuthorizedException;
use Tilta\Sdk\Exception\TiltaException;
use Tilta\Sdk\Util\Logging;

class TiltaClient
{
    /**
     * @var string
     */
    public const METHOD_POST = 'POST';

    /**
     * @var string
     */
    public const METHOD_GET = 'GET';

    /**
     * @var string
     */
    public const METHOD_PUT = 'PUT';

    /**
     * @var string
     */
    public const METHOD_PATCH = 'PATCH';

    /**
     * @var string
     */
    public const METHOD_DELETE = 'DELETE';

    /**
     * @var string
     */
    public const API_VERSION = '1';

    /**
     * @var string
     */
    public const SANDBOX_BASE_URL = 'https://api.tilta-stage.io/v' . self::API_VERSION . '/';

    /**
     * @var string
     */
    public const PRODUCTION_BASE_URL = 'https://api.tilta.io/v' . self::API_VERSION . '/';

    private ?string $apiBaseUrl;

    private ?string $authToken;

    private bool $sandbox;

    public function __construct(string $authToken = null, bool $isSandbox = false)
    {
        $this->authToken = $authToken;
        $this->sandbox = $isSandbox;
        $this->apiBaseUrl = $isSandbox ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
    }

    public function setAuthToken(string $authToken): self
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @throws TiltaException
     */
    public function request(string $url, array $data = [], string $method = self::METHOD_GET, bool $addAuthorisationHeader = true): array
    {
        $url = $this->apiBaseUrl . trim($url, '/');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $requestHeaders = [
            'Content-Type: application/json; charset=UTF-8',
            'Accept: application/json',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Connection: keep-alive',
        ];

        if ($addAuthorisationHeader) {
            $requestHeaders[] = 'Authorization: Bearer ' . $this->authToken;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);

        switch ($method) {
            case self::METHOD_POST:
                curl_setopt($ch, CURLOPT_POST, 1);
                break;
            case self::METHOD_PATCH:
            case self::METHOD_PUT:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                break;
        }

        if ($data !== []) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

        $response = curl_exec($ch);

        // log request
        $curlInfo = curl_getinfo($ch);
        $this->logRequestResponse($url, $method, $requestHeaders, $data, $response, $curlInfo);

        if (is_string($response)) {
            $response = json_decode($response, true);
        }

        $response = is_array($response) ? $response : [];

        // close connection
        curl_close($ch);

        switch ($curlInfo['http_code']) {
            case 200:
            case 201:
            case 202:
            case 204:
                return $response;
            case 400:
                throw new InvalidRequestException('Invalid request', $curlInfo['http_code'], $response, $data);
            case 401:
                throw new UserNotAuthorizedException($curlInfo['http_code'], $response, $data);
            case 404:
                throw new NotFoundException('', $curlInfo['http_code'], $response, $data);
            default:
                throw new UnexpectedServerResponse($curlInfo['http_code'], $response, $data);
        }
    }

    public function getAuthToken(): ?string
    {
        return $this->authToken;
    }

    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * @param mixed $response
     */
    private function logRequestResponse(string $url, string $method, array $requestHeaders, array $data, $response, array $curlInfo): void
    {
        try {
            if (is_string($response)) {
                if (strpos($response, '{') === 0) {
                    $response = json_decode($response, true, 512, JSON_INVALID_UTF8_IGNORE | JSON_OBJECT_AS_ARRAY);
                }
            } elseif (is_object($response)) {
                // response should never be an object - just to be safe.
                $response = method_exists($response, '__toString') ? (string) $response : get_class($response);
            }

            $logContext = [
                'request' => [
                    'url' => $url,
                    'method' => $method,
                    'data' => $data,
                ],
                'response' => [
                    'status' => $curlInfo['http_code'],
                    'data' => $response,
                ],
            ];
            if (Logging::isLogHeaders()) {
                $logContext['request']['headers'] = $requestHeaders;
            }

            if ($curlInfo['http_code'] < 200 || $curlInfo['http_code'] > 299) {
                Logging::error('API Request', $logContext);
            } else {
                Logging::debug('API Request', $logContext);
            }
        } catch (Exception $exception) {
            // do nothing - just to make sure that logging does not break the response
        }
    }
}
