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
            key: config_path(
                path: 'services',
            )
        );
    }

    public function register(): void
    {
        $this->app->singleton(
            abstract: ClientContract::class,
            concrete: fn (): ClientContract => new Client(
                url: strval(config('services.sendportal.url')),
                token: strval(config('services.sendportal.token')),
            ),
        );
    }
}
