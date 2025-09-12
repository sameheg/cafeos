<?php

namespace Modules\Dashboard\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class KpiChart extends ChartWidget
{
    protected static ?string $heading = 'Key KPIs';

    protected function getData(): array
    {
        return [
            'labels' => ['Now'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [1000],
                ],
            ],
        ];
    }
}
