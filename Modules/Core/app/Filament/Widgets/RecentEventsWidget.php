<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\Core\Models\EventLog;

class RecentEventsWidget extends Widget
{
    protected static string $view = 'core::widgets.recent-events';

    protected function getData(): array
    {
        return [
            'events' => EventLog::latest()->take(5)->get(),
        ];
    }
}
