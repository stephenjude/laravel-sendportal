# Laravel SendPortal

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stephenjude/laravel-sendportal.svg?style=flat-square)](https://packagist.org/packages/stephenjude/laravel-sendportal)
[![Test Suite](https://github.com/stephenjude/laravel-sendportal/actions/workflows/tests.yml/badge.svg)](https://github.com/stephenjude/laravel-sendportal/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/stephenjude/laravel-sendportal.svg?style=flat-square)](https://packagist.org/packages/stephenjude/laravel-sendportal)
<!--delete-->

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

This package can be used by injecting the `SendPortal\Laravel\Http\Client` into a method to instantiate the client:

```php
declare(strict_types=1);

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SendPortal\Laravel\Contracts\ClientContract;

namespace App\Jobs\SendPortal;

class SyncSubscribers implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;
    
    public function handle(ClientContract $client): void
    {
        foreach ($client->subscribers()->all() as $subscriber) {
            Subscriber::query()->updateOrCreate(
                attributes: ['email' => $subscriber->email],
                values: $subscriber->toArray(),
            );
        }
    }
}
```

Alternatively you can use the Facade to help you:

```php
declare(strict_types=1);

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SendPortal\Laravel\Facades\SendPortal;

namespace App\Jobs\SendPortal;

class SyncSubscribers implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;
    
    public function handle(): void
    {
        foreach (SendPortal::subscribers()->all() as $subscriber) {
            Subscriber::query()->updateOrCreate(
                attributes: ['email' => $subscriber->email],
                values: $subscriber->toArray(),
            );
        }
    }
}
```

### Getting a list of Subscribers

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->all();

/**
 * Using the Facade
 */
SendPortal::subscribers()->all();
```

### Getting a single Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->get(
    subscriber: 1 
);

/**
 * Using the Facade
 */
SendPortal::subscribers()->get(
    subscriber: 1,
);
```

### Creating a new Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;
use SendPortal\Laravel\Http\Requests\SubscriberRequest;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->create(
    request: new SubscriberRequest(
        email: 'contact@sendportal.local', // Required
        firstName: 'Send', // Optional
        lastName: 'Portal', // Optional
        tags: [
            'Client',
            'Awesome',
        ], // Optional
        optOut: true, // Optional
    ),
);

/**
 * Using the Facade
 */
SendPortal::subscribers()->create(
    request: new SubscriberRequest(
        email: 'contact@sendportal.local', // Required
        firstName: 'Send', // Optional
        lastName: 'Portal', // Optional
        tags: [
            'Client',
            'Awesome',
        ], // Optional
        optOut: true, // Optional
    ),
);
```

### Update a Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;
use SendPortal\Laravel\Http\Requests\SubscriberRequest;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->update(
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

/**
 * Using the Facade
 */
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
        optOut: true, // Optional
    ),
);
```

### Deleting a Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->delete(
    id: 1
);

/**
 * Using the Facade
 */
SendPortal::subscribers()->delete(
    id: 1,
);
```

### Attaching a Tag to a Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->attachTag(
    id: 1,
    tag: 1,
);

/**
 * Using the Facade
 */
SendPortal::subscribers()->attachTag(
    id: 1,
    tag: 1,
);
```

### Removing a Tag from a Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->subscribers()->removeTag(
    id: 1,
    tag: [1, 2],
);

/**
 * Using the Facade
 */
SendPortal::subscribers()->removeTag(
    id: 1,
    tag: [1, 2],
);
```

### Checking if an email address is an Active Subscriber

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->isActiveSubscriber(
    email: 'taylor@laravel.com',
);

/**
 * Using the Facade
 */
SendPortal::isActiveSubscriber(
    email: 'taylor@laravel.com',
);
```

### Getting all Tags

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->tags()->all();

/**
 * Using the Facade
 */
SendPortal::tags()->all();
```

### Creating a new Tag

```php
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Facades\SendPortal;
use SendPortal\Laravel\Http\Requests\TagRequest;

/**
 * Without a Facade
 */
$client = app()->make(
    abstract: ClientContract::class,
);

$client->tags()->create(
    request: new TagRequest(
        name: 'Test', // Required
        subscribers: [1], // Optional
    ),
);

/**
 * Using the Facade
 */
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
