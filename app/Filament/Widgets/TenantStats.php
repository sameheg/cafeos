<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Core\Models\Tenant;

class TenantStats extends ChartWidget
{
    protected static ?string $heading = 'Tenants over time';

    protected function getData(): array
    {
        $data = Tenant::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        return [
            'labels' => $data->keys()->toArray(),
            'datasets' => [
                [
                    'label' => 'Tenants',
                    'data' => $data->values()->toArray(),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
