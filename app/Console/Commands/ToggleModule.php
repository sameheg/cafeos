<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;

class ToggleModule extends Command
{
    protected $signature = 'module:toggle {name} {status}';

    public function handle(): int
    {
        $module = $this->argument('name');
        $enabled = $this->argument('status') === 'enable';

        $statusPath = base_path('modules_statuses.json');
        $statuses = File::exists($statusPath) ? json_decode(File::get($statusPath), true) : [];
        $statuses[$module] = $enabled;
        File::put($statusPath, json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        if ($enabled) {
            Module::enable($module);
            $this->call('migrate', ['--path' => "Modules/{$module}/Database/Migrations", '--force' => true]);
        } else {
            Module::disable($module);
            $this->call('route:clear');
        }

        return self::SUCCESS;
    }
}
