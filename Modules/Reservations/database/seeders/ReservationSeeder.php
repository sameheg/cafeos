<?php
namespace Modules\Reservations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservations')->insert([
            [
                'tenant_id' => 1,
                'table_id' => 1,
                'status' => 'confirmed',
                'start_at' => now()->addMinutes(30),
                'end_at' => now()->addMinutes(90),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
