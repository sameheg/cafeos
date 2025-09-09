<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'module:make {name}';

    protected $description = 'Scaffold a new module directory structure';

    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));
        $basePath = base_path("Modules/{$name}");

        $directories = [
            'Database/Migrations',
            'Http/Controllers',
            'Models',
            'Resources',
            'Routes',
            'Services',
            'Tests',
        ];

        foreach ($directories as $dir) {
            File::ensureDirectoryExists("{$basePath}/{$dir}");
        }

        $routeFile = "{$basePath}/Routes/web.php";
        if (!File::exists($routeFile)) {
            File::put($routeFile, "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n// {$name} module routes\n");
        }

        $statusPath = base_path('modules_statuses.json');
        $statuses = File::exists($statusPath) ? json_decode(File::get($statusPath), true) : [];
        if (!array_key_exists($name, $statuses)) {
            $statuses[$name] = false;
            File::put($statusPath, json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        $this->info("Module {$name} scaffolded.");
        return self::SUCCESS;
    }
}

