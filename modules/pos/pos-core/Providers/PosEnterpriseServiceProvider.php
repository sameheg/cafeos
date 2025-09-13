<?php

namespace Modules\PosEnterprise\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class PosEnterpriseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/pos-enterprise.php', 'pos-enterprise');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pos-enterprise');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pos-enterprise');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Livewire::componentNamespace('Modules\\PosEnterprise\\Livewire', 'pos-enterprise');

        $this->publishes([
            __DIR__.'/../config/pos-enterprise.php' => config_path('pos-enterprise.php'),
        ], 'pos-enterprise-config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/pos-enterprise'),
        ], 'pos-enterprise-assets');
    }
}
