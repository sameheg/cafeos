<?php

namespace Modules\ArMenu\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArMenuViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $itemId, public string $mode)
    {
    }

    public function toPayload(): array
    {
        return ['event' => 'ar.menu.viewed@v1', 'data' => ['item_id' => $this->itemId, 'mode' => $this->mode]];
    }
}
