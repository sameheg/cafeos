<?php

namespace Modules\Pos\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Observers\PosOrderObserver;

class PosServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        PosOrder::observe(PosOrderObserver::class);
        $this->loadMigrationsFrom(module_path('Pos', 'database/migrations'));
        $this->loadViewsFrom(module_path('Pos', 'resources/views'), 'pos');
        $this->mergeConfigFrom(module_path('Pos', 'config/pos.php'), 'pos');
    }
}
