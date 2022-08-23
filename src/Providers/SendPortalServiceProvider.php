<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Http\Client;

class SendPortalServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(
            path: __DIR__.'/../../config/services.php',
            key: 'services',
        );
    }

    public function register(): void
    {
        $this->app->bind(
            abstract: ClientContract::class,
            concrete: fn (): ClientContract => new Client(
                url: config('services.sendportal.url'),
                token: config('services.sendportal.token'),
            ),
        );
    }
}
