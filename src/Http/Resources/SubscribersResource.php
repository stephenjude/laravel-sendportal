<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Http\Resources;

use Illuminate\Support\Carbon;
use JustSteveKing\DataObjects\Contracts\DataObjectContract;
use SendPortal\Laravel\Collections\SubscriberCollection;
use SendPortal\Laravel\DataObjects\Name;
use SendPortal\Laravel\DataObjects\Subscriber;
use SendPortal\Laravel\DataObjects\Tag;
use SendPortal\Laravel\Enums\Method;
use SendPortal\Laravel\Enums\Status;
use SendPortal\Laravel\Exceptions\SendPortalApiException;
use SendPortal\Laravel\Http\Requests\SubscriberRequest;

class SubscribersResource extends SendPortalResource
{
    public function all(): SubscriberCollection
    {
        $response = $this->client->send(
            method: Method::GET,
            url: '/subscribers',
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return SubscriberCollection::make(
            items: array_map(
                callback: fn (array $subscriber): DataObjectContract => $this->buildSubscriber(
                    data: $subscriber
                ),
                array: (array) $response->json('data'),
            ),
        );
    }

    public function get(string $query): Subscriber
    {
        $response = $this->client->send(
            method: Method::GET,
            url: "/subscribers/{$query}",
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->collect()->toArray(),
        );
    }

    public function create(SubscriberRequest $request): Subscriber
    {
        $response = $this->client->send(
            method: Method::POST,
            url: '/subscribers',
            options: [
                'json' => $request->toArray(),
            ]
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->collect()->toArray(),
        );
    }

    public function update(string $uuid, SubscriberRequest $request): Subscriber
    {
        $response = $this->client->send(
            method: Method::PUT,
            url: "/subscribers/{$uuid}",
            options: [
                'json' => $request->toArray(),
            ]
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->collect()->toArray(),
        );
    }

    public function delete(string $uuid): bool
    {
        $response = $this->client->send(
            method: Method::DELETE,
            url: "/subscribers/{$uuid}",
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $response->successful();
    }

    public function attachTag(string $uuid, string $tag): Subscriber
    {
        $response = $this->client->send(
            method: Method::POST,
            url: "/subscribers/{$uuid}/tags",
            options: [
                'json' => ['tag' => $tag],
            ]
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->collect()->toArray(),
        );
    }

    public function removeTag(string $uuid, string $tag): Subscriber
    {
        $response = $this->client->send(
            method: Method::DELETE,
            url: "/subscribers/{$uuid}/tags/{$tag}",
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->collect()->toArray(),
        );
    }

    protected function buildSubscriber(array $data): Subscriber
    {
        return new Subscriber(
            uuid: strval(data_get($data, 'uuid')),
            email: strval(data_get($data, 'email')),
            name: new Name(
                first: strval(data_get($data, 'first_name')),
                last: strval(data_get($data, 'last_name')),
            ),
            meta: strval(data_get($data, 'meta')),
            tags: array_map(
                callback: fn (string $tag): Tag => new Tag(
                    name: $tag,
                ),
                array: (array) data_get($data, 'tags'),
            ),
            status: Status::match(
                value: strval(data_get($data, 'status')),
            ),
            confirmed: Carbon::parse(
                time: strval(data_get($data, 'confirmed_at')),
            ),
            unsubscribed: Carbon::parse(
                time: strval(data_get($data, 'unsubscribed_at')),
            ),
        );
    }
}
