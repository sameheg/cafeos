<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach (config('modules.modules', []) as $module => $settings) {
            if (!Module::has($module)) {
                continue;
            }
            if (!empty($settings['enabled'])) {
                Module::enable($module);
            } else {
                Module::disable($module);
            }
        }
    }
}
