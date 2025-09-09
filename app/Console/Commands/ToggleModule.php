<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class ToggleModule extends Command
{
    protected $signature = 'module:toggle {name} {status}';

    public function handle(): int
    {
        $module = $this->argument('name');
        $status = $this->argument('status') === 'enable';
        config(["{$module}_MODULE_ENABLED" => $status]);
        if ($status) {
            Module::enable($module);
            $this->call('migrate', ['--path' => "Modules/{$module}/Database/Migrations"]);
        } else {
            Module::disable($module);
            $this->call('route:clear');
        }
        return 0;
    }
}
