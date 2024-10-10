<?php
/*
 * Copyright (c) WEBiDEA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request;

use Exception;
use InvalidArgumentException;
use Tilta\Sdk\Exception\GatewayException;
use Tilta\Sdk\Exception\GatewayException\EmptyResponseException;
use Tilta\Sdk\Exception\TiltaException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Request\AbstractRequestModel;
use Tilta\Sdk\Model\Request\RequestModelInterface;
use Tilta\Sdk\Util\ExceptionHandler;

/**
 * @template T_RequestModel of RequestModelInterface
 * @template T_ResponseModel of AbstractModel|bool
 */
abstract class AbstractRequest
{
    protected static bool $allowEmptyResponse = false;

    public function __construct(
        protected ?TiltaClient $client = null
    ) {
    }

    final public function setClient(TiltaClient $client): void
    {
        $this->client = $client;
    }

    /**
     * @param T_RequestModel $requestModel
     * @return T_ResponseModel
     * @throws InvalidFieldValueCollectionException
     * @throws TiltaException
     */
    public function execute($requestModel)
    {
        if (!$requestModel instanceof RequestModelInterface) {
            throw new InvalidArgumentException(sprintf('Provided request model have to be an instance of %s or %s', RequestModelInterface::class, AbstractRequestModel::class));
        }

        $expectedRequestModelClass = static::getExpectedRequestModelClass();
        if (!$requestModel instanceof $expectedRequestModelClass) {
            throw new InvalidArgumentException(sprintf('Provided request model have to be an instance of %s', $expectedRequestModelClass));
        }

        try {
            if (!$this->client instanceof TiltaClient) {
                throw new InvalidArgumentException(sprintf('please set a `%s` instance to the request-service. Use the parameter in the constructor or use the function `setClient` to set the client-instance.', TiltaClient::class));
            }

            $requestModel->validateFields();

            $response = $this->client->request(
                $this->getPath($requestModel),
                $requestModel->toArray(),
                $this->getMethod($requestModel),
                $this->isAuthorisationRequired($requestModel)
            );

            if ($response === [] && !static::$allowEmptyResponse) {
                throw new EmptyResponseException();
            }
        } catch (Exception $exception) {
            if ($exception instanceof GatewayException && $requestModel instanceof AbstractModel) {
                $exception = ExceptionHandler::mapException($exception, $requestModel) ?? $exception;
            }

            $alternativeResponse = $this->getResponseModelForException($requestModel, $exception);
            if ($alternativeResponse !== null) {
                return $alternativeResponse;
            }

            $this->processFailed($requestModel, $exception);
            throw $exception;
        }

        return $this->processSuccess($requestModel, $response);
    }

    /**
     * @deprecated may be replaced with php attributes. is just used to validate the given request model
     * @return class-string<RequestModelInterface>
     */
    abstract protected static function getExpectedRequestModelClass(): string;

    /**
     * @param T_RequestModel $requestModel
     */
    abstract protected function getPath($requestModel): string;

    /**
     * @param T_RequestModel $requestModel
     * @return T_ResponseModel
     */
    abstract protected function processSuccess($requestModel, array $responseData);

    /**
     * @param T_RequestModel $requestModel
     */
    protected function processFailed($requestModel, Exception $exception): void
    {
    }

    /**
     * @param T_RequestModel $requestModel
     */
    protected function getMethod($requestModel): string
    {
        return TiltaClient::METHOD_GET;
    }

    /**
     * @param T_RequestModel $requestModel
     */
    protected function isAuthorisationRequired($requestModel): bool
    {
        return true;
    }

    /**
     * @param T_RequestModel $requestModel
     * @return T_ResponseModel|null
     */
    protected function getResponseModelForException($requestModel, Exception $exception)
    {
        return null;
    }
}
