<?php

namespace Modules\Pos\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Pos\Models\PosOrder;

class DailySalesChart extends ChartWidget
{
    protected function getData(): array
    {
        $sales = PosOrder::query()->selectRaw('DATE(created_at) as d, SUM(total) as t')->groupBy('d')->pluck('t', 'd');
        return [
            'datasets' => [['label' => 'Sales', 'data' => array_values($sales->toArray())]],
            'labels' => $sales->keys()->toArray(),
        ];
    }
}
