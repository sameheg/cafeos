<?php

namespace Modules\EquipmentMaintenance\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MonitoringAlertRaised
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $alert_id,
        public string $tenant_id,
        public string $equipment_id,
        public int $priority = 3,
    ) {
    }
}
