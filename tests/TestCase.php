<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Tests;

use SendPortal\Laravel\Providers\SendPortalServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SendPortalServiceProvider::class,
        ];
    }
}
