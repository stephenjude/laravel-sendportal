<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Http\Resources;

use Illuminate\Support\Carbon;
use JustSteveKing\DataObjects\Contracts\DataObjectContract;
use SendPortal\Laravel\Collections\TagCollection;
use SendPortal\Laravel\DataObjects\Tag;
use SendPortal\Laravel\Enums\Method;
use SendPortal\Laravel\Exceptions\SendPortalApiException;
use SendPortal\Laravel\Http\Requests\TagRequest;

class TagResource extends SendPortalResource
{
    public function all(): TagCollection
    {
        $response = $this->client->send(
            method: Method::GET,
            url: '/tags',
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return TagCollection::make(
            items: array_map(
                callback: fn(array $tag): mixed => $this->buildTag(
                    data: $tag
                ),
                array:$response->collect('data')->toArray(),
            ),
        );
    }

    public function create(TagRequest $request): DataObjectContract
    {
        $response = $this->client->send(
            method: Method::POST,
            url: '/tags',
            options: [
                'json' => $request->toArray(),
            ]
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return $this->buildTag(
            data: $response->collect('data')->toArray(),
        );
    }

    protected function buildTag(array $data): DataObjectContract
    {
        return new Tag(
            id: data_get($data, 'id'),
            name: data_get($data, 'name'),
            created: Carbon::parse(
                time: strval(data_get($data, 'created_at')),
            ),
            updated: Carbon::parse(
                time: strval(data_get($data, 'updated_at')),
            ),
        );
    }
}
