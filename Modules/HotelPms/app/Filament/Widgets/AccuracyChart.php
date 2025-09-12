<?php

namespace Modules\HotelPms\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class AccuracyChart extends ChartWidget
{
    protected function getData(): array
    {
        return [
            'datasets' => [
                ['label' => 'Accuracy', 'data' => [100]],
            ],
            'labels' => ['Posting'],
        ];
    }
}
