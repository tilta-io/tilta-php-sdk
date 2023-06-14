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
