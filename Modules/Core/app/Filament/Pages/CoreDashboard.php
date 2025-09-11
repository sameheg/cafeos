<?php

namespace Modules\Core\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Modules\Core\Filament\Widgets\TenantResolveTimeChart;
use Modules\Core\Filament\Widgets\ActiveUsersWidget;

class CoreDashboard extends BaseDashboard
{
    protected function getWidgets(): array
    {
        return [
            TenantResolveTimeChart::class,
            ActiveUsersWidget::class,
        ];
    }
}
