<?php

namespace Modules\Pos\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pos\Models\PosCustomer;

class PosDemoSeeder extends Seeder
{
    public function run(): void
    {
        PosCustomer::firstOrCreate(['tenant_id'=>'T1','name'=>'Walk-in']);
        PosCustomer::firstOrCreate(['tenant_id'=>'T1','name'=>'Regular Ahmed','phone'=>'01000000000']);
    }
}
