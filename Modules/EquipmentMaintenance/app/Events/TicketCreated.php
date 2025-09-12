<?php

namespace Modules\EquipmentMaintenance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $ticketId,
        public string $equipmentId,
    ) {
    }

    public function toPayload(): array
    {
        return [
            'ticket_id' => $this->ticketId,
            'equipment_id' => $this->equipmentId,
        ];
    }
}
