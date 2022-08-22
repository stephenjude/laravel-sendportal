<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Contracts;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use SendPortal\Laravel\Enums\Method;
use SendPortal\Laravel\Http\Resources\SubscribersResource;
use SendPortal\Laravel\Http\Resources\TagResource;

interface ClientContract
{
    public function url(): string;

    public function token(): string;

    public function makeRequest(): PendingRequest;

    public function send(Method $method, string $url, array $options = []): Response;

    public function subscribers(): SubscribersResource;

    public function tags(): TagResource;
}
