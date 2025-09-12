<?php

namespace Modules\FoodSafety\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\FoodSafety\Models\FoodSafetyAction;
use Modules\FoodSafety\Models\FoodSafetyLog;

class FoodSafetyDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $log = FoodSafetyLog::create([
            'tenant_id' => 't1',
            'item_id' => 'item-breach',
            'temp' => 10,
            'timestamp' => now(),
            'status' => 'alerted',
        ]);

        FoodSafetyAction::create([
            'tenant_id' => 't1',
            'log_id' => $log->id,
            'action' => 'Item discarded',
        ]);

        FoodSafetyLog::create([
            'tenant_id' => 't1',
            'item_id' => 'item-normal',
            'temp' => 3,
            'timestamp' => now(),
            'status' => 'monitored',
        ]);
    }
}
