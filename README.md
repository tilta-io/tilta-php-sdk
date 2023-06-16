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
