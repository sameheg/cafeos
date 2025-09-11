<?php

namespace Modules\Kiosk\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class OrdersPerDayChart extends ChartWidget
{
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => [1,2,3,4,5,6,7],
                ],
            ],
            'labels' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        ];
    }
}
