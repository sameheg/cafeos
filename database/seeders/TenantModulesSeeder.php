<?php

namespace Database\Seeders;

use App\Models\TenantModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TenantModulesSeeder extends Seeder
{
    public function run(): void
    {
        $statusPath = base_path('modules_statuses.json');
        $statuses = File::exists($statusPath) ? json_decode(File::get($statusPath), true) : [];

        foreach ($statuses as $module => $enabled) {
            TenantModule::updateOrCreate(
                ['module' => $module, 'tenant_id' => tenant('id')],
                ['enabled' => $enabled]
            );
        }
    }
}
