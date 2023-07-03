## Usage

### General usage

For every request there is a

* request service (instance of `\Tilta\Sdk\Service\Request\AbstractRequest`)
  Knows anything about the request itself (url, method, authorization)
* request model (instance of `\Tilta\Sdk\Model\Response\AbstractRequestModel`)
  Knows anything about the parameters of the request, and acts as DTO to submit the data to the request service
* response model (instance of `\Tilta\Sdk\Model\Response\AbstractResponseModel`)
  Knows anything about the response data, and acts as DTO to receives the data from the request service Note: in some
  cases there is not response. Just a `true` got returned from the RequestService if the request was successful.

### Get a `\Tilta\Sdk\HttpClient\TiltaClient`-instance

Use the `\Tilta\Sdk\Util\TiltaClientFactory` to get a new instance.

The factory will store the generated `TiltaClient`-instance in a static variable. So it will not produce a new request,
if you request a new `TiltaClient`-instance.

```php
$isSandbox = true;
$tiltaClient = \Tilta\Sdk\Util\TiltaClientFactory::getClientInstance('YOUR_TOKEN', $isSandbox);
```

Provide a boolean as second parameter to define if the request goes against the sandbox or not.

### Get an instance of a request service

You can simply create a new instance of the corresponding service.

*Example*:

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $tiltaClient **/

$requestService = new \Tilta\Sdk\Service\Request\RequestServiceClass($tiltaClient);
```

You must not provide the `TiltaClient` via the constructor, but you should set it, before calling `execute` on the
request service.

*Example*:

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $tiltaClient **/

$requestService = new \Tilta\Sdk\Service\Request\RequestServiceClass();
// [...]
$requestService->setClient($tiltaClient);
// [...]
$requestService->execute(...);
```

### Models

#### Request models: Validation

Every field of a request model (not response models) will be validated automatically, during calling its setter. If you
provide a wrong value or in an invalid format, an `\Tilta\Sdk\Exception\Validation\InvalidFieldException` will be
thrown.

You can disable this automatic validation, by calling the method `setValidateOnSet` on the model:

```php
/** @var \Tilta\Sdk\Model\Request\AbstractRequestModel $requestModel */

$requestModel->setValidateOnSet(false);
```

The model got validate at least by the request service, to make sure that all data has been provided, and you will get
no validation exception through the gateway.

#### Response models

Every response model is set to be read-only.

You can not set any fields on this model. You will get a `BadMethodCallException`.

### Requests

This documentation should not explain the whole usage of each request. It should only show the main information about
each request, and the main usage.

Please have a look into the corresponding documentation of each API Request.

#### GetBuyerAuthTokenRequest

| 	                 | 	                                                                     |
|-------------------|-----------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-auth-buyer-external-id) |
| Request service   | `\Tilta\Sdk\Service\Request\Buyer\GetBuyerAuthTokenRequest`           |
| Request model     | `\Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel`        |
| Response model    | `\Tilta\Sdk\Model\Response\Buyer\GetBuyerAuthTokenResponseModel`      |

Use this service to generate JWT token for the buyer, so he can use the buyer-onboarding requests.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$tokenRequestService = new \Tilta\Sdk\Service\Request\Buyer\GetBuyerAuthTokenRequest($client, $isSandbox);

$requestModel = new \Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel('EXTERNAL-MERCHANT-ID');
    
/** @var \Tilta\Sdk\Model\Response\Buyer\GetBuyerAuthTokenResponseModel */
$responseModel = $tokenRequestService->execute($requestModel);
$accessToken = $responseModel->getBuyerAuthToken();
```

#### GetBuyerDetailsRequest

| 	                 | 	                                                                 |
|-------------------|-------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers-external-id) |
| Request service   | `\Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest`         |
| Request model     | `\Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel`      |
| Response model    | `\Tilta\Sdk\Model\Buyer`                                          |

Use this service to fetch a buyer from the gateway by its external-id (of the merchant)

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$tokenRequestService = new \Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest($client, $isSandbox);

$requestModel = new \Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel('EXTERNAL-MERCHANT-ID');
    
/** @var \Tilta\Sdk\Model\Buyer */
$responseModel = $tokenRequestService->execute($requestModel);
$externalId = $responseModel->getExternalId();
$legalName = $responseModel->getLegalName();
[...]
```

#### GetBuyerListRequest

| 	                 | 	                                                            |
|-------------------|--------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers)        |
| Request service   | `\Tilta\Sdk\Service\Request\Buyer\GetBuyerListRequest`       |
| Request model     | `\Tilta\Sdk\Model\Request\Buyer\GetBuyersListRequestModel`   |
| Response model    | `\Tilta\Sdk\Model\Response\Buyer\GetBuyersListResponseModel` |

Use this service to get all buyers. Use `limit` & `offset` to navigate through the pages.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$tokenRequestService = new \Tilta\Sdk\Service\Request\Buyer\GetBuyerListRequest($client, $isSandbox);

$requestModel = (new \Tilta\Sdk\Model\Request\Buyer\GetBuyersListRequestModel())
    // optional parameters
    ->setLimit(10)
    ->setOffset(0);
    
/** @var \Tilta\Sdk\Model\Response\Buyer\GetBuyersListResponseModel */
$responseModel = $tokenRequestService->execute($requestModel);
$limit = $responseModel->getLimit();
$limit = $responseModel->getOffset();
$limit = $responseModel->getTotal();
/** @var \Tilta\Sdk\Model\Buyer[] $items */
$items = $responseModel->getItems();
$legalNameOfCompany1 = $items[0]->getLegalName();
$legalNameOfCompany2 = $items[1]->getLegalName();
[...]
```

#### CreateBuyerRequest

| 	                 | 	                                                      |
|-------------------|--------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers) |
| Request service   | `\Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest`  |
| Request model     | `\Tilta\Sdk\Model\Buyer`                               |
| Response model    | `true`                                                 |

Use this service to create a new buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$requestService = new \Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest($client, $isSandbox);

$requestModel = (new \Tilta\Sdk\Model\Buyer())
    ->setExternalId('EXTERNAL_MERCHANT_ID')
    ->setTradingName('Trading name')
    ->setLegalForm('GMBH')
    ->setLegalName('Legal name')
    ->setRegisteredAt((new DateTime())->setDate(2000, 2, 12))
    ->setIncorporatedAt((new DateTime())->setDate(2002, 5, 30))
    ->setRepresentatives(new \Tilta\Sdk\Model\BuyerRepresentative())
    ->setBusinessAddress(new \Tilta\Sdk\Model\Address())
    ->setCustomData([
        'custom-key' => 'custom-value1',
        'custom-key2' => 'custom-value2'
    ]);
    
/** @var boolean $response */
$response = $requestService->execute($requestModel); // true if successfully
```

#### UpdateBuyerRequest

| 	                 | 	                                                                  |
|-------------------|--------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers-external-id) |
| Request service   | `\Tilta\Sdk\Service\Request\Buyer\UpdateBuyerRequest`              |
| Request model     | `\Tilta\Sdk\Model\Request\Buyer\UpdateBuyerRequestModel`           |
| Response model    | `true`                                                             |

Use this service to update buyers data.

You must not provide all buyers data, just these data, which you want to update. If you data of a sub-object (
e.g. `representatives` or `businessAddress`), you have to provide all data, to prevent validation issues. This behaviour
may change in the future.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$requestService = new \Tilta\Sdk\Service\Request\Buyer\UpdateBuyerRequest($client, $isSandbox);

$requestModel = (new \Tilta\Sdk\Model\Request\Buyer\UpdateBuyerRequestModel('EXTERNAL_MERCHANT_ID'))
    // same methods as in the \Tilta\Sdk\Model\Buyer model. You must provide all data, just these data, which should be updated.
    ->setTradingName('Trading name')
    ->setCustomData([
        'custom-key' => 'custom-value1',
        'custom-key2' => 'custom-value2'
    ]);
    
/** @var boolean $response */
$response = $requestService->execute($requestModel); // true if successfully
```

#### CreateFacilityRequest

| 	                 | 	                                                                           |
|-------------------|-----------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers-external-id-facility) |
| Request service   | `\Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest`                 |
| Request model     | `\Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel`              |
| Response model    | `true`                                                                      |

Use this service to create a new facility for a buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$requestService = new \Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest($client, $isSandbox);

$requestModel = (new \Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel('EXTERNAL_MERCHANT_ID'));
    
/** @var boolean $response */
$response = $requestService->execute($requestModel); // true if successfully
```

#### GetFacilityRequest

| 	                 | 	                                                                          |
|-------------------|----------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers-external-id-facility) |
| Request service   | `\Tilta\Sdk\Service\Request\Facility\GetFacilityRequest`                   |
| Request model     | `\Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel`                |
| Response model    | `\Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel`              |

Use this service to get the active facility for a buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
/** @var boolean $isSandbox */
$requestService = new \Tilta\Sdk\Service\Request\Facility\GetFacilityRequest($client, $isSandbox);

$requestModel = (new \Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel('EXTERNAL_MERCHANT_ID'));
    
/** @var \Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel $response */
$response = $requestService->execute($requestModel);
$response->getBuyerExternalId();
$response->getAvailableAmount();
[...]
```

__Expected exceptions thrown by service__

| 	                                                                               | 	                                             |
|---------------------------------------------------------------------------------|-----------------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException` | if the buyer does not have an active facility |
| `Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException` | if the buyer does not exist.                  |

#### CreateOrderRequestModel

| 	                 | 	                                                                                                             |
|-------------------|---------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-orders)                                                        |
| Request service   | [\Tilta\Sdk\Service\Request\Order\CreateOrderRequest](src/Service/Request/Order/CreateOrderRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel](src/Model/Request/Order/CreateOrderRequestModel.php) |
| Response model    | [\Tilta\Sdk\Model\Order](src/Model/Order.php)                                                                 |

Use this service to create a new order for a buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\CreateOrderRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\CreateOrderRequestModel())
            ->setOrderExternalId('order-external-id')
            ->setBuyerExternalId('buyer-external-id')
            ->setMerchantExternalId('merchant-external-id')
            ->setAmount(new \Tilta\Sdk\Model\Order\Amount())
            ->setComment('order-comment')
            ->setOrderedAt((new DateTime()))
            ->setPaymentMethod(\Tilta\Sdk\Enum\PaymentMethodEnum::BNPL)
            ->setDeliveryAddress(new \Tilta\Sdk\Model\Address()))
            ->setLineItems([
                new \Tilta\Sdk\Model\Order\LineItem(),
                new \Tilta\Sdk\Model\Order\LineItem(),
                new \Tilta\Sdk\Model\Order\LineItem(),
            ]);
    
/** @var \Tilta\Sdk\Model\Order $response */
$response = $requestService->execute($requestModel);
$orderStatus = $response->getStatus();
[...]
```

__Expected exceptions thrown by service__

| 	                                                                                   | 	                                                                          |
|-------------------------------------------------------------------------------------|----------------------------------------------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException`    | if the buyer does not exist.                                               |
| `\Tilta\Sdk\Exception\GatewayException\Facility\NoActiveFacilityFoundException`     | if the buyer does not have an active facility.                             |
| `\Tilta\Sdk\Exception\GatewayException\Facility\FacilityExceededException`          | if the buyer have an active facility but the order would exceed the limit. |
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException` | if the provided merchant does not exist.                                   |

#### GetOrderDetailsRequest

| 	                 | 	                                                                                                                     |
|-------------------|-----------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-orders-external-id)                                                     |
| Request service   | [\Tilta\Sdk\Service\Request\Order\GetOrderDetailsRequest](src/Service/Request/Order/GetOrderDetailsRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Order\GetOrderDetailsRequestModel](src/Model/Request/Order/GetOrderDetailsRequestModel.php) |
| Response model    | [\Tilta\Sdk\Model\Order](src/Model/Order.php)                                                                         |

Use this service to fetch order by the external-id.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\GetOrderDetailsRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\GetOrderDetailsRequestModel('order-external-id'));
    
/** @var \Tilta\Sdk\Model\Order $response */
$response = $requestService->execute($requestModel);
$externalId = $response->getOrderExternalId();
$orderStatus = $response->getStatus();
[...]
```

__Expected exceptions thrown by service__

| 	                                                                                   | 	                                                                          |
|-------------------------------------------------------------------------------------|----------------------------------------------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException`    | if the order does not exist.                                               |

### Additional features

#### Logging

you can enable logging all API Requests. (maybe we will log other things in the future, too).

You just have to give us an instance of `\Psr\Log\LoggerInterface`. This could be a logger of the
popular [monolog/monolog](https://github.com/Seldaek/monolog) package.

Please note, you can only pass a logger of the mentioned interface. If you have a custom logger, you have to implement
the interface. Do not forget to install the package [psr/log](https://github.com/php-fig/log).

**Please note:** you should not set a debug-logger in production, because this will log all requests (successful and
failed). If you only set a ERROR-Handler it will only log all failed requests.

Example:

```php
$logFile = ;
$logger = new \Monolog\Logger('name-for-the-logger');

$handlerDebug = new \Monolog\Handler\StreamHandler('/path/to/your/log-file.error.log', LogLevel::DEBUG);
$logger->pushHandler($handlerDebug);
$handlerError = new \Monolog\Handler\StreamHandler('/path/to/your/log-file.debug.log', LogLevel::ERROR);
$logger->pushHandler($handlerError);

\Tilta\Sdk\Util\Logging::setPsr3Logger($logger);
// call this if you want to log the request-headers too 
\Tilta\Sdk\Util\Logging::setLogHeaders(true);
```
