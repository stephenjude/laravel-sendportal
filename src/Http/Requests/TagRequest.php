<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Http\Requests;

use JustSteveKing\DataObjects\Contracts\DataObjectContract;

class TagRequest implements DataObjectContract
{
    public function __construct(
        protected readonly string $name,
        protected readonly null|array $subscribers = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'subscribers' => $this->subscribers,
        ];
    }
}
