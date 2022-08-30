<?php

declare(strict_types=1);

namespace SendPortal\Laravel\DataObjects;

use Illuminate\Support\Carbon;
use JustSteveKing\DataObjects\Contracts\DataObjectContract;

class Tag implements DataObjectContract
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly null|Carbon $created,
        public readonly null|Carbon $updated,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created' =>  $this->created,
            'updated' =>  $this->updated,
        ];
    }
}
