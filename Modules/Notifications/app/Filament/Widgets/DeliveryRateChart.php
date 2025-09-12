<?php

namespace Modules\Notifications\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Modules\Notifications\Models\NotificationLog;

class DeliveryRateChart extends LineChartWidget
{
    protected static ?string $heading = 'Delivery Rate';

    protected function getData(): array
    {
        $delivered = NotificationLog::where('status', 'sent')->count();
        $total = NotificationLog::count();
        $rate = $total ? ($delivered / $total) * 100 : 0;

        return [
            'datasets' => [
                [
                    'label' => 'Delivery %',
                    'data' => [$rate],
                ],
            ],
        ];
    }
}
