<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Http\Client;
use SendPortal\Laravel\Http\Resources\SubscribersResource;
use SendPortal\Laravel\Http\Resources\TagResource;

/**
 * @method static SubscribersResource subscribers()
 * @method static TagResource tags()
 * @method static bool isActiveSubscriber(int $subscriberId)
 *
 * @see Client
 */
class SendPortal extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ClientContract::class;
    }
}
