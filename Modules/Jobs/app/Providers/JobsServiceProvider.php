<?php

namespace Modules\Jobs\Providers;

use Illuminate\Support\ServiceProvider;

class JobsServiceProvider extends ServiceProvider
{
    protected string $name = 'Jobs';

    protected string $nameLower = 'jobs';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath, $this->nameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
        }
    }
}
