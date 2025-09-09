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
            'Resources/views',
            'Resources/lang/en',
            'Resources/lang/ar',
            'Routes',
            'Services',
            'Tests/Feature',
        ];

        foreach ($directories as $dir) {
            File::ensureDirectoryExists("{$basePath}/{$dir}");
        }

        $table = Str::snake(Str::pluralStudly($name));

        $migrationName = date('Y_m_d_His') . "_create_{$table}_table.php";
        $migrationPath = "{$basePath}/Database/Migrations/{$migrationName}";
        if (!File::exists($migrationPath)) {
            $migrationStub = <<<'PHP'
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;
            File::put($migrationPath, $migrationStub);
        }

        $modelPath = "{$basePath}/Models/{$name}.php";
        if (!File::exists($modelPath)) {
            $modelStub = <<<'PHP'
<?php

namespace Modules\\{$name}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$name} extends Model
{
    protected $fillable = ['tenant_id'];
}
PHP;
            File::put($modelPath, $modelStub);
        }

        $langEn = "{$basePath}/Resources/lang/en/messages.php";
        if (!File::exists($langEn)) {
            File::put($langEn, "<?php\n\nreturn [\n    'example' => 'Example',\n];\n");
        }

        $langAr = "{$basePath}/Resources/lang/ar/messages.php";
        if (!File::exists($langAr)) {
            File::put($langAr, "<?php\n\nreturn [\n    'example' => 'مثال',\n];\n");
        }

        $testPath = "{$basePath}/Tests/Feature/{$name}ModuleTest.php";
        if (!File::exists($testPath)) {
            $testStub = <<<'PHP'
<?php

namespace Modules\\{$name}\\Tests\\Feature;

use Tests\\TestCase;

class {$name}ModuleTest extends TestCase
{
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
PHP;
            File::put($testPath, $testStub);
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

