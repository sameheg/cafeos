<?php

namespace Modules\HotelPms\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\HotelPms\Models\Folio;

class FolioPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Folio $folio)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('pms.folios');
    }

    public function broadcastAs(): string
    {
        return 'pms.folio.posted';
    }

    public function broadcastWith(): array
    {
        return [
            'folio_id' => $this->folio->id,
            'amount' => (float) $this->folio->total,
        ];
    }
}
