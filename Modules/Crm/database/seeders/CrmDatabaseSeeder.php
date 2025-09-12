<?php

declare(strict_types=1);

namespace Modules\Crm\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Crm\Models\Customer;
use Modules\Crm\Models\Segment;

class CrmDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = (string) \Illuminate\Support\Str::uuid();

        $lapsed = Customer::create([
            'tenant_id' => $tenant,
            'name' => 'Lapsed Customer',
            'email' => 'lapsed@example.com',
            'rfm_score' => 1,
        ]);

        Segment::create([
            'tenant_id' => $tenant,
            'name' => 'lapsed',
            'criteria' => ['rfm_score' => 1],
        ]);
    }
}
