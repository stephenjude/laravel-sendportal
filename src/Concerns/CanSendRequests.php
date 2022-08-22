<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Concerns;

use Illuminate\Http\Client\Response;
use SendPortal\Laravel\Http\Client;
use SendPortal\Laravel\Enums\Method;

/**
 * @mixin Client
 */
trait CanSendRequests
{
    public function send(
        Method $method,
        string $url,
        array $options = [],
    ): Response {
        return $this
            ->makeRequest()
            ->send(
                method: $method->value,
                url: $url,
                options: $options,
            );
    }
}
