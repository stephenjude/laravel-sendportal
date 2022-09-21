<?php

declare(strict_types=1);

use SendPortal\Laravel\Collections\SubscriberCollection;
use SendPortal\Laravel\DataObjects\Subscriber;
use SendPortal\Laravel\Http\Client;
use SendPortal\Laravel\Http\Requests\SubscriberRequest;

it('can get a list of subscribers', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                [
                    'id' => $integer,
                    'email' => $string,
                    'first_name' => $string,
                    'last_name' => $string,
                    'unsubscribed_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => $integer,
                    'email' => $string,
                    'first_name' => $string,
                    'last_name' => $string,
                    'unsubscribed_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->subscribers()->all(),
    )->toBeInstanceOf(
        SubscriberCollection::class
    )->each(
        fn ($subscriber) => $subscriber->toBeInstanceOf(Subscriber::class),
    );
})->with('integers', 'strings');

it('can get a single subscriber', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                'id' => $integer,
                'email' => $string,
                'first_name' => $string,
                'last_name' => $string,
                'unsubscribed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->subscribers()->get(subscriberId: $integer),
    )->toBeInstanceOf(
        Subscriber::class
    );
})->with('integers', 'strings');

it('can create a new subscriber', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                'id' => $integer,
                'email' => $string,
                'first_name' => $string,
                'last_name' => $string,
                'unsubscribed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->subscribers()->create(
            request: new SubscriberRequest(
                email: $string,
                firstName: $string,
                lastName: $string,
                tags: [1, 2],
                optOut: false,
            ),
        ),
    )->toBeInstanceOf(Subscriber::class);
})->with('integers', 'strings');

it('can update a subscriber', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                'id' => $integer,
                'email' => $string,
                'first_name' => $string,
                'last_name' => $string,
                'unsubscribed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->subscribers()->update(
            subscriberId: $integer,
            request: new SubscriberRequest(
                email: $string,
                optOut: false,
            ),
        )
    )->toBeInstanceOf(Subscriber::class);
})->with('integers', 'strings');

it('can delete a subscriber', function (int $integer, string $string) {
    fakeClient(
        body: null,
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->subscribers()->delete(
            subscriberId: $integer,
        )
    )->toBeBool()->toEqual(true);
})->with('integers', 'strings');

it('can check if an email is an active subscriber', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                'id' => $integer,
                'email' => $string,
                'first_name' => $string,
                'last_name' => $string,
                'unsubscribed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->isActiveSubscriber(
            subscriberId: $integer,
        ),
    )->toBeBool()->toEqual(true);
})->with('integers', 'strings');

it('can check if an email is an inactive subscriber', function (int $integer, string $string) {
    fakeClient(
        body: [
            'data' => [
                'id' => $integer,
                'email' => $string,
                'first_name' => $string,
                'last_name' => $string,
                'unsubscribed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ],
    );

    $client = new Client(
        url: $string,
        token: $string,
    );

    expect(
        $client->isActiveSubscriber(
            subscriberId: $integer,
        ),
    )->toBeBool()->toEqual(false);
})->with('integers', 'strings');
