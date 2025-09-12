<?php

namespace Modules\HRJobs\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ReliabilityChart extends ChartWidget
{
    protected static ?string $heading = 'Attendance Reliability';

    protected function getData(): array
    {
        return [
            'datasets' => [
                ['label' => 'Attendance', 'data' => [95, 96, 94]],
            ],
            'labels' => ['Jan', 'Feb', 'Mar'],
        ];
    }
}

