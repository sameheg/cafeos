<?php

namespace Modules\Reservations\Database\Seeders;

use Illuminate\Database\Seeder;

class ReservationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Modules\Core\Models\Tenant::firstOrCreate([
            'id' => 'seed-tenant',
        ], [
            'name' => 'Seed Tenant',
            'subdomain' => 'seed',
        ]);

        \Modules\Reservations\Models\ReservationSlot::create([
            'tenant_id' => 'seed-tenant',
            'date' => now()->toDateString(),
            'capacity' => 10,
        ]);

        \Modules\Reservations\Models\Reservation::create([
            'tenant_id' => 'seed-tenant',
            'table_id' => 'table-seed',
            'time' => now()->subMinutes(20),
            'status' => \Modules\Reservations\Models\ReservationStatus::NoShow,
        ]);
    }
}
