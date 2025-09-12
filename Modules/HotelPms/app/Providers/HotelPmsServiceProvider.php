<?php

namespace Modules\HotelPms\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\HotelPms\Adapters\DummyPmsAdapter;
use Modules\HotelPms\Adapters\PmsAdapterInterface;
use Modules\HotelPms\Models\Folio;
use Modules\HotelPms\Observers\FolioObserver;

class HotelPmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PmsAdapterInterface::class, DummyPmsAdapter::class);
    }

    public function boot(): void
    {
        Folio::observe(FolioObserver::class);
        $this->loadMigrationsFrom(module_path('HotelPms', 'database/migrations'));
        $this->loadViewsFrom(module_path('HotelPms', 'resources/views'), 'hotelpms');
        $this->mergeConfigFrom(module_path('HotelPms', 'config/pms.php'), 'pms');
    }
}
