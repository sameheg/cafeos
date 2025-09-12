<?php

namespace Modules\EquipmentLeasing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\EquipmentLeasing\Models\EquipmentLease;
use Modules\EquipmentLeasing\Models\EquipmentListing;

class EquipmentLeasingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $listing = EquipmentListing::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Seeded Excavator',
            'available' => true,
        ]);

        EquipmentLease::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => $listing->tenant_id,
            'equipment_id' => $listing->id,
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);
    }
}

