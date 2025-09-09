<?php

namespace Modules\Notifications\Providers;

use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    protected string $name = 'Notifications';
    protected string $nameLower = 'notifications';

    public function boot(): void
    {
        $this->publishes([
            module_path($this->name, 'config/config.php') => config_path('notifications.php'),
        ], 'config');

        $this->mergeConfigFrom(module_path($this->name, 'config/config.php'), 'notifications');
    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }
}
