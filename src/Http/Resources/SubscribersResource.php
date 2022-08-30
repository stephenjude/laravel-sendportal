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
                callback: fn(array $subscriber): DataObjectContract => $this->buildSubscriber(
                    data: $subscriber
                ),
                array: $response->collect('data')->toArray(),
            ),
        );
    }

    public function get(int $subscriberId): Subscriber
    {
        $response = $this->client->send(
            method: Method::GET,
            url: "/subscribers/{$subscriberId}",
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->json('data'),
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
            data: $response->json('data'),
        );
    }

    public function update(int $subscriberId, SubscriberRequest $request): Subscriber
    {
        $response = $this->client->send(
            method: Method::PUT,
            url: "/subscribers/{$subscriberId}",
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
            data: $response->json('data'),
        );
    }

    public function delete(int $subscriberId): bool
    {
        $response = $this->client->send(
            method: Method::DELETE,
            url: "/subscribers/{$subscriberId}",
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $response->successful();
    }

    public function attachTag(int $subscriberId, int $tag): Subscriber
    {
        $response = $this->client->send(
            method: Method::POST,
            url: "/subscribers/{$subscriberId}/tags",
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
            data: $response->json('data'),
        );
    }

    public function removeTag(int $subscriberId, int $tag): Subscriber
    {
        $response = $this->client->send(
            method: Method::DELETE,
            url: "/subscribers/{$subscriberId}/tags/{$tag}",
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildSubscriber(
            data: $response->json('data'),
        );
    }

    protected function buildSubscriber(array $data): Subscriber
    {
        return new Subscriber(
            id: (int)data_get($data, 'id'),
            email: strval(data_get($data, 'email')),
            name: new Name(
                first: strval(data_get($data, 'first_name')),
                last: strval(data_get($data, 'last_name')),
            ),
            unsubscribed: data_get($data, 'unsubscribed_at')
                ? Carbon::parse(
                    time: strval(data_get($data, 'unsubscribed_at'))
                )
                : null,
            created: Carbon::parse(
                time: strval(data_get($data, 'created_at')),
            ),
            updated: Carbon::parse(
                time: strval(data_get($data, 'updated_at')),
            ),
        );
    }
}
