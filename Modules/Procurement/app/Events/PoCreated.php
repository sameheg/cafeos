<?php

namespace Modules\Procurement\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Procurement\Models\Po;

class PoCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Po $po) {}

    public function toPayload(): array
    {
        return [
            'event' => 'procurement.po.created',
            'data' => [
                'po_id' => (string) $this->po->id,
                'supplier_id' => (string) optional($this->po->bid)->supplier_id,
            ],
        ];
    }
}
