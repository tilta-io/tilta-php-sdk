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

| 	                 | 	                                                                                                                             |
|-------------------|-------------------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-auth-buyer-external-id)                                                         |
| Request service   | [\Tilta\Sdk\Service\Request\Buyer\GetBuyerAuthTokenRequest](src/Service/Request/Buyer/GetBuyerAuthTokenRequest.php)           |
| Request model     | [\Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel](src/Model/Request/Buyer/GetBuyerAuthTokenRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Buyer\GetBuyerAuthTokenResponseModel](src/Model/Response/Buyer/GetBuyerAuthTokenResponseModel.php) |

Use this service to generate JWT token for the buyer, so he can use the buyer-onboarding requests.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$tokenRequestService = new \Tilta\Sdk\Service\Request\Buyer\GetBuyerAuthTokenRequest($client);

$requestModel = new \Tilta\Sdk\Model\Request\Buyer\GetBuyerAuthTokenRequestModel('EXTERNAL-MERCHANT-ID');
    
/** @var \Tilta\Sdk\Model\Response\Buyer\GetBuyerAuthTokenResponseModel */
$responseModel = $tokenRequestService->execute($requestModel);
$accessToken = $responseModel->getBuyerAuthToken();
```

#### GetBuyerDetailsRequest

| 	                 | 	                                                                                                                     |
|-------------------|-----------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers-external-id)                                                     |
| Request service   | [\Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest](src/Service/Request/Buyer/GetBuyerDetailsRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel](src/Model/Request/Buyer/GetBuyerDetailsRequestModel.php) |
| Response model    | [\Tilta\Sdk\Model\Buyer](src/Model/Buyer.php)                                                                         |

Use this service to fetch a buyer from the gateway by its external-id (of the merchant)

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$tokenRequestService = new \Tilta\Sdk\Service\Request\Buyer\GetBuyerDetailsRequest($client);

$requestModel = new \Tilta\Sdk\Model\Request\Buyer\GetBuyerDetailsRequestModel('EXTERNAL-MERCHANT-ID');
    
/** @var \Tilta\Sdk\Model\Buyer */
$responseModel = $tokenRequestService->execute($requestModel);
$externalId = $responseModel->getExternalId();
$legalName = $responseModel->getLegalName();
[...]
```

#### GetBuyerListRequest

| 	                 | 	                                                                                                                     |
|-------------------|-----------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers)                                                                 |
| Request service   | [\Tilta\Sdk\Service\Request\Buyer\GetBuyerListRequest](src/Service/Request/Buyer/GetBuyerListRequest.php)             |
| Request model     | [\Tilta\Sdk\Model\Request\Buyer\GetBuyersListRequestModel](src/Model/Request/Buyer/GetBuyersListRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Buyer\GetBuyersListResponseModel](src/Model/Response/Buyer/GetBuyersListResponseModel.php) |

Use this service to get all buyers. Use `limit` & `offset` to navigate through the pages.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$tokenRequestService = new \Tilta\Sdk\Service\Request\Buyer\GetBuyerListRequest($client);

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

| 	                 | 	                                                                                                       |
|-------------------|---------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers)                                                  |
| Request service   | [\Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest](src/Service/Request/Buyer/CreateBuyerRequest.php) |
| Request model     | [\Tilta\Sdk\Model\Buyer](src/Model/Buyer.php)                                                           |
| Response model    | `true`                                                                                                  |

Use this service to create a new buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Buyer\CreateBuyerRequest($client);

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

| 	                 | 	                                                                                                             |
|-------------------|---------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers-external-id)                                            |
| Request service   | [\Tilta\Sdk\Service\Request\Buyer\UpdateBuyerRequest](src/Service/Request/Buyer/UpdateBuyerRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Buyer\UpdateBuyerRequestModel](src/Model/Request/Buyer/UpdateBuyerRequestModel.php) |
| Response model    | `true`                                                                                                        |

Use this service to update buyers data.

You must not provide all buyers data, just these data, which you want to update. If you data of a sub-object (
e.g. `representatives` or `businessAddress`), you have to provide all data, to prevent validation issues. This behaviour
may change in the future.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Buyer\UpdateBuyerRequest($client);

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

| 	                 | 	                                                                                                                         |
|-------------------|---------------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers-external-id-facility)                                               |
| Request service   | [\Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest](src/Service/Request/Facility/CreateFacilityRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel](src/Model/Request/Facility/CreateFacilityRequestModel.php) |
| Response model    | `true`                                                                                                                    |

Use this service to create a new facility for a buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Facility\CreateFacilityRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Facility\CreateFacilityRequestModel('EXTERNAL_MERCHANT_ID'));
    
/** @var boolean $response */
$response = $requestService->execute($requestModel); // true if successfully
```

#### GetFacilityRequest

| 	                 | 	                                                                                                                       |
|-------------------|-------------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers-external-id-facility)                                              |
| Request service   | [\Tilta\Sdk\Service\Request\Facility\GetFacilityRequest](src/Service/Request/Facility/GetFacilityRequest.php)           |
| Request model     | [\Tilta\Sdk\Model\Request\Facility\GetFacilityRequestModel](src/Model/Request/Facility/GetFacilityRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Facility\GetFacilityResponseModel](src/Model/Response/Facility/GetFacilityResponseModel.php) |

Use this service to get the active facility for a buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Facility\GetFacilityRequest($client);

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

| 	                                                                                | 	                            |
|----------------------------------------------------------------------------------|------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException` | if the order does not exist. |

#### GetOrderListRequest

| 	                 | 	                                                                                                                   |
|-------------------|---------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-orders)                                                               |
| Request service   | [\Tilta\Sdk\Service\Request\Order\GetOrderListRequest](src/Service/Request/Order/GetOrderListRequest.php)           |
| Request model     | [\Tilta\Sdk\Model\Request\Order\GetOrderListRequestModel](src/Model/Request/Order/GetOrderListRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Order\GetOrderListResponseModel](src/Model/Response/Order/GetOrderListResponseModel.php) |

Use this service to fetch all orders.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\GetOrderListRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\GetOrderListRequestModel())
    // optional for pagination:
    ->setOffset(150)
    ->setLimit(50)
    ->setMerchantExternalId('merchant-external-id')
    ->setPaymentMethod(\Tilta\Sdk\Enum\PaymentMethodEnum::BNPL);
    
/** @var \Tilta\Sdk\Model\Response\Order\GetOrderListResponseModel $response */
$response = $requestService->execute($requestModel);
$totalItemCount = $response->getTotal();
/** @var Tilta\Sdk\Model\Order[] $items */
$items = $response->getItems();
[...]
```

#### CancelOrderRequest

| 	                 | 	                                                                                                             |
|-------------------|---------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-orders-external-id)                                             |
| Request service   | [\Tilta\Sdk\Service\Request\Order\CancelOrderRequest](src/Service/Request/Order/CancelOrderRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Order\CancelOrderRequestModel](src/Model/Request/Order/CancelOrderRequestModel.php) |
| Response model    | [\Tilta\Sdk\Model\Order](src/Model/Order.php)                                                                 |

Use this service to cancel the order (if it hasn't been invoiced yet).

**Please note:** If the request was successful, an order-object is returned, instead of a boolean!

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\CancelOrderRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\CancelOrderRequestModel('order-external-id'));
    
/** @var \Tilta\Sdk\Model\Order $response */
$response = $requestService->execute($requestModel);
$externalId = $response->getOrderExternalId();
$response->getStatus() === \Tilta\Sdk\Enum\OrderStatusEnum::CANCELED; // true
[...]
```

__Expected exceptions thrown by service__

| 	                                                                                  | 	                                       |
|------------------------------------------------------------------------------------|-----------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderNotFoundException`   | if the order does not exist.            |
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\OrderIsCanceledException` | if the order has been already canceled. |

#### CancelOrderRequest

| 	                 | 	                                                                                                                                   |
|-------------------|-------------------------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers-external-id-orders)                                                            |
| Request service   | [\Tilta\Sdk\Service\Request\Order\GetOrderListForBuyerRequest](src/Service/Request/Order/GetOrderListForBuyerRequest.php)           |
| Request model     | [\Tilta\Sdk\Model\Request\Order\GetOrderListForBuyerRequestModel](src/Model/Request/Order/GetOrderListForBuyerRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Order\GetOrderListForBuyerResponseModel](src/Model/Response/Order/GetOrderListForBuyerResponseModel.php) |

Use this service to fetch all orders for given buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\GetOrderListForBuyerRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\GetOrderListForBuyerRequestModel('buyer-external-id'));
    
/** @var \Tilta\Sdk\Model\Response\Order\GetOrderListForBuyerResponseModel $response */
$response = $requestService->execute($requestModel);
/** @var \Tilta\Sdk\Model\Order[] $items */
$items = $response->getItems();
```

__Expected exceptions thrown by service__

| 	                                                                                | 	                                  |
|----------------------------------------------------------------------------------|------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException` | if the given buyer does not exist. |

#### GetPaymentTermsRequest

| 	                 | 	                                                                                                                         |
|-------------------|---------------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-buyers-external-id-orders-paymentterms)                                    |
| Request service   | [\Tilta\Sdk\Service\Request\Order\GetPaymentTermsRequest](src/Service/Request/Order/GetPaymentTermsRequest.php)           |
| Request model     | [\Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel](src/Model/Request/Order/GetPaymentTermsRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Order\GetPaymentTermsResponseModel](src/Model/Response/Order/GetPaymentTermsResponseModel.php) |

Use this service to get the payment terms for an order, which would/may be placed.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\GetPaymentTermsRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\GetPaymentTermsRequestModel())
    ->setMerchantExternalId('merchant-external-id')
    ->setBuyerExternalId('buyer-external-id')
    ->setAmount(new \Tilta\Sdk\Model\Order\Amount());
    
/** @var \Tilta\Sdk\Model\Response\Order\GetPaymentTermsResponseModel $response */
$response = $requestService->execute($requestModel);
```

__Expected exceptions thrown by service__

| 	                                                                                   | 	                                                                          |
|-------------------------------------------------------------------------------------|----------------------------------------------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException`    | if the given buyer does not exist.                                         |
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException` | if the given merchant does not exist.                                      |
| `\Tilta\Sdk\Exception\GatewayException\Facility\FacilityExceededException`          | if the buyer have an active facility but the order would exceed the limit. |

#### AddOrdersToBuyerRequest

| 	                 | 	                                                                                                                           |
|-------------------|-----------------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-buyers-external-id-orders)                                                    |
| Request service   | [\Tilta\Sdk\Service\Request\Order\AddOrdersToBuyerRequest](src/Service/Request/Order/AddOrdersToBuyerRequest.php)           |
| Request model     | [\Tilta\Sdk\Model\Request\Order\AddOrdersToBuyerRequestModel](src/Model/Request/Order/AddOrdersToBuyerRequestModel.php)     |
| Response model    | [\Tilta\Sdk\Model\Response\Order\AddOrdersToBuyerResponseModel](src/Model/Response/Order/AddOrdersToBuyerResponseModel.php) |

Use this service to add existing orders, which are not processed by Tilta, to the buyer debtor.

**Please note**: The `ExistingOrder`-Model is just a subclass of the `Order`-Model. The difference is, that you can
not set the `buyerExternalId` for the order, because this value has to be set on the request-model (once).
So please make sure that you only provide orders, for one single buyer.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Order\AddOrdersToBuyerRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Order\AddOrdersToBuyerRequestModel('buyer-external-id'))
    ->setItems([
        new \Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder('oder-id-1'),
        new \Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder('oder-id-2'),
        new \Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder('oder-id-3')
    ])
    ->addOrderItem(new \Tilta\Sdk\Model\Request\Order\AddOrdersToBuyer\ExistingOrder('oder-id-4'));
    
/** @var \Tilta\Sdk\Model\Response\Order\AddOrdersToBuyerResponseModel $response */
$response = $requestService->execute($requestModel);
/** @var \Tilta\Sdk\Model\Order[] $items */
$items = $response->getItems();
```

__Expected exceptions thrown by service__

| 	                                                                                   | 	                                                            |
|-------------------------------------------------------------------------------------|--------------------------------------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\BuyerNotFoundException`    | if the given buyer does not exist.                           |
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\MerchantNotFoundException` | if the given merchant for at least one order does not exist. |

#### CreateInvoiceRequest

| 	                 | 	                                                                                                                     |
|-------------------|-----------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/post_v1-invoices)                                                              |
| Request service   | [\Tilta\Sdk\Service\Request\Invoice\CreateInvoiceRequest](src/Service/Request/Invoice/CreateInvoiceRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel](src/Model/Request/Invoice/CreateInvoiceRequestModel.php) |
| Response model    | [\Tilta\Sdk\Model\Invoice](src/Model/Invoice.php)                                                                     |

Use this service to add create a new Invoice for (multiple) orders.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Invoice\CreateInvoiceRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel())
    ->setInvoiceExternalId('invoice-external-id')
    ->setInvoiceNumber('invoice-number')
    ->setOrderExternalIds(['order-external-id-1', 'order-external-id-2']) // just provide an array with one value, if you create an invoice for a single order.
    ->setAmount(new \Tilta\Sdk\Model\Order\Amount())
    ->setDeliveryAddress(new \Tilta\Sdk\Model\Address())
    ->setLineItems([
      new \Tilta\Sdk\Model\Order\LineItem(),
      new \Tilta\Sdk\Model\Order\LineItem(),
      new \Tilta\Sdk\Model\Order\LineItem(),
      new \Tilta\Sdk\Model\Order\LineItem(),
    ]);
    
/** @var \Tilta\Sdk\Model\Invoice $response */
$response = $requestService->execute($requestModel);
```

__Expected exceptions thrown by service__

| 	    | 	    |
|------|------|
| TODO | TODO |
| TODO | TODO |

#### GetInvoiceRequest

| 	                 | 	                                                                                                                  |
|-------------------|--------------------------------------------------------------------------------------------------------------------|
| Api documentation | [Link](https://docs.tilta.io/reference/get_v1-invoices-external-id)                                                |
| Request service   | [\Tilta\Sdk\Service\Request\Invoice\CreateInvoiceRequest](src/Service/Request/Invoice/GetInvoiceRequest.php)       |
| Request model     | [\Tilta\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel](src/Model/Request/Invoice/GetInvoiceRequestModel.php) |
| Response model    | [\Tilta\Sdk\Model\Invoice](src/Model/Invoice.php)                                                                  |

Use this service to fetch a single invoice.

__Usage__

```php
/** @var \Tilta\Sdk\HttpClient\TiltaClient $client */
$requestService = new \Tilta\Sdk\Service\Request\Invoice\GetInvoiceRequest($client);

$requestModel = (new \Tilta\Sdk\Model\Request\Invoice\GetInvoiceRequestModel('invoice-external-id'));
    
/** @var \Tilta\Sdk\Model\Invoice $response */
$response = $requestService->execute($requestModel);
```

__Expected exceptions thrown by service__

| 	                                                                                  | 	                              |
|------------------------------------------------------------------------------------|--------------------------------|
| `\Tilta\Sdk\Exception\GatewayException\NotFoundException\InvoiceNotFoundException` | if the invoice does not exist. |

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
