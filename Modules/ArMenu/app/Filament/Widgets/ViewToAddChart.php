<?php

namespace Modules\ArMenu\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\ArMenu\Models\ArInteraction;
use Modules\ArMenu\Models\ArAsset;

class ViewToAddChart extends ChartWidget
{
    protected static ?string $heading = 'View to Add';

    protected function getData(): array
    {
        $views = ArInteraction::count();
        $adds = ArAsset::where('state', 'added')->count();
        return [
            'datasets' => [
                ['label' => 'Views', 'data' => [$views]],
                ['label' => 'Adds', 'data' => [$adds]],
            ],
            'labels' => ['Last 30d'],
        ];
    }
}
