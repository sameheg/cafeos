<?php

namespace Modules\Core\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class JsonDomainEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $event,
        public array $data,
        public string $event_id
    ) {
    }
}
