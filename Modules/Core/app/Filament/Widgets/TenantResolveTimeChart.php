<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TenantResolveTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Tenant Resolve Time';

    protected function getData(): array
    {
        return [
            'labels' => ['Jan', 'Feb'],
            'datasets' => [
                [
                    'label' => 'Resolve Time',
                    'data' => [10, 20],
                ],
            ],
        ];
    }
}
