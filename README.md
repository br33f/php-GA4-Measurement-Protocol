# Google Analytics 4 Measurement Protocol PHP Library
[![Coverage Status](https://coveralls.io/repos/github/br33f/php-GA4-Measurement-Protocol/badge.svg?branch=master)](https://coveralls.io/github/br33f/php-GA4-Measurement-Protocol?branch=master)
[![Latest Stable Version](https://poser.pugx.org/br33f/php-ga4-mp/v/stable.png)](https://packagist.org/packages/br33f/php-ga4-mp)
[![Total Downloads](https://poser.pugx.org/br33f/php-ga4-mp/downloads.png)](https://packagist.org/packages/br33f/php-ga4-mp)
## Overview
This is a PHP Library facilitating the use of Google Analytics 4 (GA4) Measurement Protocol. Measurement Protocol allows developers to send events directly from server-side PHP to Google Analytics. 

Full documentation is available here:
https://developers.google.com/analytics/devguides/collection/protocol/ga4

## Requirements
- PHP >= 7.1
- ext-json
- guzzlehttp/guzzle: ^6.5.5 || ^7.0.0

dev:
- phpunit/phpunit: "^9.5"
- fakerphp/faker: "^1.14"

## Installation
The recommended way to install this library is via [Composer](https://getcomposer.org/ "Composer") (packagist package: [br33f/php-ga4-mp](https://packagist.org/packages/br33f/php-ga4-mp "br33f/php-ga4-mp")).

Install by composer command:

```
composer require br33f/php-ga4-mp
```

or `package.json`
```
{
    "require": {
        "br33f/php-ga4-mp": "^0.1.0"
    }
}
```

## Usage

### Send View Item Event
```php
use Br33f\Ga4\MeasurementProtocol\Service;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\ViewItemEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;

// Create service instance
$ga4Service = new Service('MEASUREMENT_PROTOCOL_API_SECRET');
$ga4Service->setMeasurementId('MEASUREMENT_ID');

// Create base request
$baseRequest = new BaseRequest();
$baseRequest->setClientId('CLIENT_ID');

// Create Event Data
$viewItemEventData = new ViewItemEvent();
$viewItemEventData
    ->setValue(51.10)
    ->setCurrency('EUR');

// Create Item
$viewedItem = new ItemParameter();
$viewedItem
    ->setItemId('ITEM_ID')
    ->setItemName('ITEM_NAME')
    ->setPrice(25.55)
    ->setQuantity(2);
    
// Add this item to viewItemEventData   
$viewItemEventData->addItem($viewedItem);

// Add event to base request (you can add up to 25 events to single request)
$baseRequest->addEvent($viewItemEventData);

// We have all the data we need. Just send the request.
$ga4Service->send($baseRequest);

```

### Send Purchase Event
```php
use Br33f\Ga4\MeasurementProtocol\Service;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\PurchaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;

// Create service instance
$ga4Service = new Service('MEASUREMENT_PROTOCOL_API_SECRET');
$ga4Service->setMeasurementId('MEASUREMENT_ID');

// Create base request
$baseRequest = new BaseRequest();
$baseRequest->setClientId('CLIENT_ID');

// Create Event Data
$purchaseEventData = new PurchaseEvent();
$purchaseEventData
    ->setValue(250.00)
    ->setCurrency('USD');

// Create Item
$purchasedItem1 = new ItemParameter();
$purchasedItem1
    ->setItemId('FIRST_ITEM_ID')
    ->setItemName('FIRST_ITEM_NAME')
    ->setPrice(100.00)
    ->setQuantity(2);
    
// Add this item to purchaseEventData
$purchaseEventData->addItem($purchasedItem1);

// You can also fill item data via constructor
$purchaseEventData->addItem(new ItemParameter([
    'item_id' => 'SECOND_ITEM_ID',
    'item_name' => 'SECOND_ITEM_NAME',
    'price' => 50.00,
    'quantity' => 1
]));

// Add event to base request (you can add up to 25 events to single request)
$baseRequest->addEvent($purchaseEventData);

// We have all the data we need. Just send the request.
$ga4Service->send($baseRequest);

```

At the moment, the library contains the defined structures of the following events:
| Event name | Structure | Documentation |
| ---------- | --------- | --------------|
| add_payment_info | AddPaymentInfoEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#add_payment_info)
| add_shipping_info | AddShippingInfoEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#add_shipping_info)
| add_to_cart | AddToCartEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#add_to_cart)
| begin_checkout | BeginCheckoutEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#begin_checkout)
| login | LoginEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#login)
| purchase | PurchaseEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#purchase)
| refund | RefundEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#refund)
| remove_from_cart | RemoveFromCartEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#remove_from_cart)
| search | SearchEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#search)
| select_item | SelectItemEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#select_item)
| sign_up | SignUpEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#sign_up)
| view_cart | ViewCartEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#view_cart)
| view_item | ViewItemEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#view_item)
| view_search_results | ViewSearchResultsEvent | [see documentation](https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#view_search_results)

These events are sent analogously to the examples presented above.

### Other events
In order to send any event one can use `BaseEvent` structure and add any data. Please note that specific event structure should be used instead if already defined, since BaseEvent does not force any structure or provide data validation.

```php
use Br33f\Ga4\MeasurementProtocol\Service;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;

// Create Service and request same as above
// ...

// Create Base Event Data (for example: 'share' event - https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events#share)
$eventName = 'share'; 
$anyEventData = new BaseEvent($eventName);
$anyEventData
    ->setMethod('Twitter')
    ->setContentType('Post')
    ->setItemId('example_item_id')
    ->setAnyParamYouWish('test'); // means 'any_param_you_wish' is set


// Add event to base request (you can add up to 25 events to single request) and send, same as above
// ...

```

### Firebase Support
It is possible to use this library to send Firebase events. To do so, just initialize Service and BaseRequest as in following example:

```php
use Br33f\Ga4\MeasurementProtocol\Service;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;

// Create service instance
$ga4Service = new Service('MEASUREMENT_PROTOCOL_API_SECRET');
$ga4Service->setFirebaseId('FIREBASE_APP_ID'); // instead of setMeasurementId(...)

// Create base request
$baseRequest = new BaseRequest();
$baseRequest->setAppInstanceId('APP_INSTANCE_ID'); // instead of setClientId(...)
```


## Debug event data and requests
Debuging event data is possible by sending them to debug endpoint (Measurement Protocol Validation Server), since default endpoint for Google Analytics 4 Measurement Protocol does not return any HTTP error codes or messages. In order to validate event one should use `sendDebug($request)` method instead of `send($request)`.

Method `sendDebug($request)` returns `DebugResponse` object, which is hydrated with response data such as: `status_code` and `validation_messages`.

### Example:
```php
use Br33f\Ga4\MeasurementProtocol\Service;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\AddToCartEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\ItemParameter;

// Create service instance
$ga4Service = new Service('MEASUREMENT_PROTOCOL_API_SECRET');
$ga4Service->setMeasurementId('MEASUREMENT_ID');

// Create base request
$baseRequest = new BaseRequest();
$baseRequest->setClientId('CLIENT_ID');

// Create Invalid Event Data
$addToCartEventData = new AddToCartEvent();
$addToCartEventData
    ->setValue(99.99)
    ->setCurrency('SOME_INVALID_CURRENCY_CODE'); // invalid currency code

// addItem
$addToCartEventData->addItem(new ItemParameter([
    'item_id' => 'ITEM_ID',
    'item_name' => 'ITEM_NAME',
    'price' => 99.99,
    'quantity' => 1
]));

// Add event to base request (you can add up to 25 events to single request)
$baseRequest->addEvent($addToCartEventData);

// Instead of sending data to production Measurement Protocol endpoint
// $ga4Service->send($baseRequest); 
// Send data to validation endpoint, which responds with status cude and validation messages.
$debugResponse = $ga4Service->sendDebug($baseRequest);

// Now debug response contains status code, and validation messages if request is invalid
var_dump($debugResponse->getStatusCode()); 
var_dump($debugResponse->getValidationMessages());

```

## Unit Testing
Unit Testing for this module is done using PHPUnit 9.

Running unit tests:
```
composer install
php vendor/bin/phpunit
```

## License
This library is released under the MIT License.
