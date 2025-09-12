<?php

namespace Modules\EquipmentLeasing\Observers;

use Illuminate\Support\Facades\Event;
use Modules\EquipmentLeasing\Models\EquipmentLease;

class EquipmentLeaseObserver
{
    public function created(EquipmentLease $lease): void
    {
        Event::dispatch('equipment.lease.signed@v1', [
            'lease_id' => $lease->id,
            'equipment_id' => $lease->equipment_id,
        ]);
    }
}

