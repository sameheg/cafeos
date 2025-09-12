<?php

namespace Modules\SuperAdmin\Filament\Pages;

use Filament\Pages\Page;
use Modules\SuperAdmin\Filament\Widgets\HealthMonitor;
use Modules\SuperAdmin\Filament\Widgets\MttrChart;

class SuperAdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static string $view = 'superadmin::dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            HealthMonitor::class,
            MttrChart::class,
        ];
    }
}
