<?php

namespace Modules\Core\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class ActiveUsersWidget extends Widget
{
    protected static string $view = 'core::widgets.active-users';

    protected function getData(): array
    {
        return [
            'count' => User::count(),
        ];
    }
}
