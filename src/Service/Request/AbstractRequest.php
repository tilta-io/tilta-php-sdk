<?php
/*
 * Copyright (c) Tilta Fintech GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tilta\Sdk\Service\Request;

use Exception;
use InvalidArgumentException;
use RuntimeException;
use Tilta\Sdk\Exception\GatewayException\EntityNotFoundException;
use Tilta\Sdk\Exception\GatewayException\NotFoundException;
use Tilta\Sdk\Exception\TiltaException;
use Tilta\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Tilta\Sdk\HttpClient\TiltaClient;
use Tilta\Sdk\Model\AbstractModel;
use Tilta\Sdk\Model\Request\AbstractRequestModel;
use Tilta\Sdk\Model\Request\EntityRequestModelInterface;

/**
 * @template T_RequestModel of AbstractRequestModel
 * @template T_ResponseModel of AbstractModel|bool
 */
abstract class AbstractRequest
{
    protected ?TiltaClient $client;

    public function __construct(TiltaClient $client = null)
    {
        $this->client = $client;
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
        } catch (Exception $exception) {
            if ($exception instanceof NotFoundException) {
                $this->processNotFound($requestModel, $exception);
            }

            $this->processFailed($requestModel, $exception);
            throw $exception;
        }

        return $this->processSuccess($requestModel, $response);
    }

    /**
     * @param T_RequestModel $requestModel
     */
    abstract protected function getPath($requestModel): string;

    /**
     * @param T_RequestModel $requestModel
     * @return T_ResponseModel
     */
    abstract protected function processSuccess($requestModel, ?array $responseData = null);

    /**
     * @param T_RequestModel $requestModel
     */
    protected function processFailed($requestModel, Exception $exception): void
    {
    }

    /**
     * @param T_RequestModel $requestModel
     * @throws EntityNotFoundException
     */
    protected function processNotFound($requestModel, NotFoundException $exception): void
    {
        if ($requestModel instanceof EntityRequestModelInterface) {
            $exceptionClass = $this->getNotFoundExceptionClass();
            if ($exceptionClass === null) {
                $exception->setExternalId($requestModel->getExternalId());

                return;
            }

            if (!is_subclass_of($exceptionClass, EntityNotFoundException::class)) {
                throw new RuntimeException(sprintf('%s needs to be an subclass of %s', $exceptionClass, EntityNotFoundException::class));
            }

            throw new $exceptionClass(
                $requestModel->getExternalId(),
                $exception->getCode(),
                $exception->getResponseData(),
                $exception->getRequestData()
            );
        }
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return null;
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
}
