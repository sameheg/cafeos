<?php

namespace Modules\EquipmentMaintenance\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EquipmentMaintenance\Enums\TicketStatus;
use Modules\EquipmentMaintenance\Models\MaintenanceSchedule;
use Modules\EquipmentMaintenance\Models\MaintenanceTicket;

class EquipmentMaintenanceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MaintenanceTicket::create([
            'tenant_id' => 't1',
            'equipment_id' => 'eq1',
            'priority' => 5,
            'status' => TicketStatus::Delayed,
        ]);

        MaintenanceSchedule::create([
            'tenant_id' => 't1',
            'equipment_id' => 'eq2',
            'next_date' => now()->addWeek()->toDateString(),
        ]);
    }
}
