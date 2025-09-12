<?php

namespace Modules\EquipmentMaintenance\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Modules\EquipmentMaintenance\Enums\TicketStatus;
use Modules\EquipmentMaintenance\Events\MonitoringAlertRaised;
use Modules\EquipmentMaintenance\Models\MaintenanceTicket;

class CreateTicketFromAlert implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 4;

    public $backoff = [1, 2, 4, 8];

    public string $queue = 'high';

    public function handle(MonitoringAlertRaised $event): void
    {
        $key = 'maintenance:alert:' . $event->alert_id;
        if (! Cache::add($key, true, now()->addDay())) {
            return; // idempotent
        }

        MaintenanceTicket::create([
            'tenant_id' => $event->tenant_id,
            'equipment_id' => $event->equipment_id,
            'priority' => $event->priority,
            'status' => TicketStatus::Scheduled,
        ]);
    }
}
