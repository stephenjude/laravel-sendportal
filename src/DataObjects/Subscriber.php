<?php

declare(strict_types=1);

namespace SendPortal\Laravel\DataObjects;

use Illuminate\Support\Carbon;
use JustSteveKing\DataObjects\Contracts\DataObjectContract;
use SendPortal\Laravel\Enums\Status;

class Subscriber implements DataObjectContract
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly Name $name,
        public readonly null|Carbon $unsubscribed,
        public readonly null|Carbon $created,
        public readonly null|Carbon $updated,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name->toArray(),
            'unsubscribed' => $this->unsubscribed,
            'created' =>  $this->created,
            'updated' =>  $this->updated,
        ];
    }
}
