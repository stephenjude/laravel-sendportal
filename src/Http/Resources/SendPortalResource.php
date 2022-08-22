<?php

declare(strict_types=1);

namespace SendPortal\Laravel\Http\Resources;

use SendPortal\Laravel\Contracts\ClientContract;
use SendPortal\Laravel\Contracts\ResourceContract;

class SendPortalResource implements ResourceContract
{
    public function __construct(
        protected readonly ClientContract $client,
    ) {
    }
}
