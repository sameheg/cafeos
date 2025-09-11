<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;

class ModuleReleaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'module:release {name} {version}';

    /**
     * The console command description.
     */
    protected $description = 'Release a module with the given version.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $module = $this->argument('name');
        $version = $this->argument('version');

        $this->info("Module {$module} released with version {$version}.");

        return self::SUCCESS;
    }
}
