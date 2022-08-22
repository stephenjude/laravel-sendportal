<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Http\Resources;

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
            url   : '/tags',
        );

        if ($response->failed()) {
            throw new SendPortalApiException(
                response: $response,
            );
        }

        return TagCollection::make(
            items: array_map(
                callback: fn (string $tag): mixed => $this->buildTag(
                    data: $tag
                ),
                array: (array) $response->json('data'),
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
            data: strval($response->collect()->first()),
        );
    }

    protected function buildTag(string $data): DataObjectContract
    {
        return new Tag(
            name: $data,
        );
    }
}
