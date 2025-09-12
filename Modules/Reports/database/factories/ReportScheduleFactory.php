<?php

namespace Modules\Reports\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Reports\Models\ReportSchedule;
use Modules\Reports\Models\Report;

class ReportScheduleFactory extends Factory
{
    protected $model = ReportSchedule::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (string) Str::uuid(),
            'report_id' => Report::factory(),
            'frequency' => 'daily',
        ];
    }
}
