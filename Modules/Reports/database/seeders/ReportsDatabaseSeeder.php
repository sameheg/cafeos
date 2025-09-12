<?php

namespace Modules\Reports\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reports\Models\Report;

class ReportsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::factory()->create([
            'generated_at' => now()->subHours(2),
        ]);

        Report::factory()->create([
            'data' => ['total' => 'invalid'],
        ]);
    }
}
