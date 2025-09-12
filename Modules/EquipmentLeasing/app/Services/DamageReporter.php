<?php

namespace Modules\EquipmentLeasing\Services;

use Illuminate\Support\Facades\Event;
use Modules\EquipmentLeasing\Models\EquipmentLease;

class DamageReporter
{
    public function report(EquipmentLease $lease, string $details): void
    {
        $lease->reportDamage();
        Event::dispatch('equipment.damage.reported@v1', [
            'lease_id' => $lease->id,
            'details' => $details,
        ]);
    }
}

