<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $statusPath = base_path('modules_statuses.json');
        $statuses = File::exists($statusPath) ? json_decode(File::get($statusPath), true) : [];

        foreach (Module::all() as $module) {
            $name = $module->getName();
            if ($statuses[$name] ?? false) {
                Module::enable($name);
            } else {
                Module::disable($name);
            }
        }
    }
}
