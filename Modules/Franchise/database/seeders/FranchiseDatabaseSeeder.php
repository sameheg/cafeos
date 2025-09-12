<?php

namespace Modules\Franchise\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Franchise\Models\FranchiseBranch;
use Modules\Franchise\Models\FranchiseTemplate;

class FranchiseDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        FranchiseBranch::create([
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Demo Branch',
        ]);

        FranchiseTemplate::create([
            'tenant_id' => (string) Str::uuid(),
            'type' => 'recipe',
            'data' => ['price' => 10],
        ]);
    }
}
