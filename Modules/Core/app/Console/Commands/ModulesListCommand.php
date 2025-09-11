<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;

class ModulesListCommand extends Command
{
    protected $signature = 'modules:list';

    protected $description = 'List installed modules';

    public function handle(): int
    {
        $modulesPath = base_path('Modules');
        $modules = collect(scandir($modulesPath))
            ->reject(fn ($item) => in_array($item, ['.', '..']))
            ->filter(fn ($dir) => is_dir($modulesPath.DIRECTORY_SEPARATOR.$dir));

        foreach ($modules as $module) {
            $manifest = @json_decode(file_get_contents($modulesPath.DIRECTORY_SEPARATOR.$module.'/manifest.json'), true);
            $this->line($module.($manifest ? ' v'.$manifest['version'] : ''));
        }

        return self::SUCCESS;
    }
}
