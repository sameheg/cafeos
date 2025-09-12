<?php
namespace Modules\Reservations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reservations\App\Models\Reservation;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::create([
            'tenant_id' => 1,
            'table_id' => 5,
            'status' => 'confirmed',
            'start_at' => now()->addMinutes(30),
            'end_at' => now()->addHours(2),
        ]);

        Reservation::create([
            'tenant_id' => 1,
            'table_id' => 7,
            'status' => 'seated',
            'start_at' => now()->subMinutes(15),
            'end_at' => now()->addMinutes(45),
        ]);
    }
}
