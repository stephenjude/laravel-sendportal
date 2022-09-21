# Laravel SendPortal SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stephenjude/laravel-sendportal.svg?style=flat-square)](https://packagist.org/packages/stephenjude/laravel-sendportal)
[![Test Suite](https://github.com/stephenjude/laravel-sendportal/actions/workflows/tests.yml/badge.svg)](https://github.com/stephenjude/laravel-sendportal/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/stephenjude/laravel-sendportal.svg?style=flat-square)](https://packagist.org/packages/stephenjude/laravel-sendportal)
<!--delete-->

The unofficial Laravel Package to work with the [SendPortal](https://sendportal.io/) APIs.

## Installation

You can install the package via composer:

```bash
composer require stephenjude/laravel-sendportal
```

## Set up

To start using this package, you need to add environment variables for:

- `SENDPORTAL_URL` - The url of your Sendportal account like this — https://sendportal.io/api/v1
- `SENDPORTAL_TOKEN` - You can generate this from your SendPortal account.

The package will pick these up in its configuration and use these when it resolves an instance of the `Client`.

## Usage

This package can be used by using the `SendPortal` facade or by injecting the `SendPortal\Laravel\Http\Client` into a method to instantiate the client:
```php
use SendStack\Laravel\Contracts\ClientContract;
use SendStack\Laravel\Facades\SendStack;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->all();


/**
 *  Using the Facade
 */
SendPortal::subscribers()->all();
```

### Getting a list of Subscribers

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::subscribers()->all();
```

### Getting a single Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::subscribers()->get(
    subscriber: 1,
);
```

### Creating a new Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;
use SendPortal\Laravel\Http\Requests\SubscriberRequest;

SendPortal::subscribers()->create(
    request: new SubscriberRequest(
        email: 'contact@sendportal.local', // Required
        firstName: 'Send', // Optional
        lastName: 'Portal', // Optional
        tags: [
            1,
            2,
        ], // Optional
        optOut: false, // Optional
    ),
);
```

### Update a Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;
use SendPortal\Laravel\Http\Requests\SubscriberRequest;

SendPortal::subscribers()->update(
    id: 1,
    request: new SubscriberRequest(
        email: 'contact@sendportal.local', // Required
        firstName: 'Send', // Optional
        lastName: 'Portal', // Optional
        tags: [
            1,
            2,
        ], // Optional
        optOut: false, // Optional
    ),
);
```

### Deleting a Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::subscribers()->delete(
    subscriberId: 1,
);
```

### Attaching a Tag to a Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::subscribers()->attachTag(
    subscriberId: 1,
    tagId: 1,
);
```

### Removing a Tag from a Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::subscribers()->removeTag(
    subscriberId: 1,
    tagIds: [1, 2],
);
```

### Checking if an email address is an Active Subscriber

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::isActiveSubscriber(
    subscriberId: 1,
);
```

### Getting all Tags

```php
use SendPortal\Laravel\Facades\SendPortal;

SendPortal::tags()->all();
```

### Creating a new Tag

```php
use SendPortal\Laravel\Facades\SendPortal;
use SendPortal\Laravel\Http\Requests\TagRequest;

SendPortal::tags()->create(
    request: new TagRequest(
        name: 'Test', // Required
        subscribers: [1], // Optional
    ),
);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Stephen Jude](https://github.com/stephenjude)
- [Steve McDougall](https://github.com/juststeveking)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
