<?php

namespace Modules\Reports\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Reports\Models\Report;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (string) Str::uuid(),
            'type' => 'sales',
            'data' => ['total' => 100],
            'generated_at' => now(),
        ];
    }
}
