<?php

namespace Modules\ArMenu\Providers;

use Illuminate\Support\ServiceProvider;

class ArMenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'ar-menu');
    }
}
