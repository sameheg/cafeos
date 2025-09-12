<?php

namespace Modules\SuperAdmin\Filament\Widgets;

use Filament\Widgets\Widget;

class HealthMonitor extends Widget
{
    protected static string $view = 'superadmin::widgets.health-monitor';

    protected function getViewData(): array
    {
        return ['ok' => true];
    }
}
