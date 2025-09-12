<?php

namespace Modules\EquipmentMonitoring\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EquipmentMonitoring\Models\MonitoringThreshold;

class EquipmentMonitoringSeeder extends Seeder
{
    public function run(): void
    {
        MonitoringThreshold::create([
            'tenant_id' => '00000000-0000-0000-0000-000000000000',
            'metric' => 'pressure',
            'min' => 10,
            'max' => 20,
        ]);
    }
}
