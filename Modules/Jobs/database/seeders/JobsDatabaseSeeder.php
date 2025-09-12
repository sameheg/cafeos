<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Jobs\Models\JobApplication;
use Modules\Jobs\Models\JobPosting;

class JobsDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $posting = JobPosting::factory()->create();
        JobApplication::factory()->count(50)->create([
            'posting_id' => $posting->id,
        ]);
    }
}
