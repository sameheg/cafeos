<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $modulesPath = base_path('Modules');

        if (! File::isDirectory($modulesPath)) {
            return;
        }

        foreach (File::glob($modulesPath.'/*/module.json') as $manifest) {
            $config = json_decode(File::get($manifest), true);
            $providers = $config['providers'] ?? [];

            foreach ($providers as $provider) {
                $this->app->register($provider);
            }
        }
    }
}
