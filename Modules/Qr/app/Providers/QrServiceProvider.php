<?php

namespace Modules\Qr\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Qr\Models\QrOrder;
use Modules\Qr\Observers\QrOrderObserver;

class QrServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        QrOrder::observe(QrOrderObserver::class);
        $this->loadMigrationsFrom(module_path('Qr', 'database/migrations'));
        $this->mergeConfigFrom(module_path('Qr', 'config/qr.php'), 'qr');
    }
}
