<?php

declare(strict_types=1);

use SendPortal\Laravel\Collections\TagCollection;
use SendPortal\Laravel\DataObjects\Tag;
use SendPortal\Laravel\Http\Client;
use SendPortal\Laravel\Http\Requests\TagRequest;

it('can get a list of tags', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                [
                    'id' => $integer,
                    'name' => $string,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => $integer,
                    'name' => $string,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->tags()->all(),
    )->toBeInstanceOf(
        TagCollection::class
    )->each(
        fn($tag) => $tag
            ->toBeInstanceOf(Tag::class),
    );
})->with('integers', 'strings');

it('can create a new tag', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                'id' => $integer,
                'name' => $string,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->tags()->create(
            request: new TagRequest(
                name: $string,
            ),
        ),
    )->toBeInstanceOf(Tag::class);
})->with('integers', 'strings');
