<?php

namespace Modules\FoodSafety\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\FoodSafety\Models\FoodSafetyLog;

class IncidentChart extends ChartWidget
{
    protected static ?string $heading = 'Incidents';

    protected function getData(): array
    {
        $data = FoodSafetyLog::where('status', 'alerted')
            ->selectRaw('DATE(timestamp) as d, COUNT(*) as c')
            ->groupBy('d')->orderBy('d')->get();

        return [
            'datasets' => [
                ['label' => 'Incidents', 'data' => $data->pluck('c')],
            ],
            'labels' => $data->pluck('d'),
        ];
    }
}
