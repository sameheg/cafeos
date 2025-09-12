<?php

namespace Modules\Membership\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Membership\Models\MembershipPerk;

class MembershipDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MembershipPerk::create([
            'tenant_id' => Str::uuid(),
            'tier' => 'silver',
            'description' => 'Basic support',
        ]);

        MembershipPerk::create([
            'tenant_id' => Str::uuid(),
            'tier' => 'gold',
            'description' => 'Priority support',
        ]);
    }
}
