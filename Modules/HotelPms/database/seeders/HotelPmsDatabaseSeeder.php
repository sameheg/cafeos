<?php

namespace Modules\HotelPms\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HotelPms\Models\Folio;
use Illuminate\Support\Str;

class HotelPmsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Folio::create([
            'tenant_id' => (string) Str::uuid(),
            'guest_id' => 'seed-guest',
            'total' => 100,
            'status' => Folio::STATUS_POSTED,
        ]);
    }
}
