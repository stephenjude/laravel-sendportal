<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Http;

use Closure;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use SendPortal\Laravel\Concerns\CanAccessProperties;
use SendPortal\Laravel\Concerns\CanBuildRequests;
use SendPortal\Laravel\Concerns\CanSendRequests;
use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Http\Resources\SubscribersResource;
use SendPortal\Laravel\Http\Resources\TagResource;
use Throwable;

class Client implements ClientContract
{
    use CanAccessProperties;
    use CanBuildRequests;
    use CanSendRequests;

    public function __construct(
        protected readonly string $url,
        protected readonly string $token,
    ) {
    }

    public static function fake(Closure|array $callback): Factory
    {
        return Http::fake(
            callback: $callback,
        );
    }

    public function subscribers(): SubscribersResource
    {
        return new SubscribersResource(
            client: $this,
        );
    }

    public function tags(): TagResource
    {
        return new TagResource(
            client: $this,
        );
    }

    public function isActiveSubscriber(int $subscriberId): bool
    {
        try {
            $subscriber = $this->subscribers()->get(
                subscriberId: $subscriberId,
            );
        } catch (Throwable) {
            return false;
        }

        if (!is_null($subscriber->unsubscribed)) {
            return false;
        }

        return true;
    }
}
