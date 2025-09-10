<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MakeModuleCommandTest extends TestCase
{
    public function test_scaffolding_creates_expected_components(): void
    {
        $module = 'Blog';
        $this->artisan('module:make', ['name' => $module]);

        $basePath = base_path("Modules/{$module}");

        $migrationFiles = glob("{$basePath}/Database/Migrations/*_create_blogs_table.php");
        $this->assertNotEmpty($migrationFiles);
        $migrationContent = File::get($migrationFiles[0]);
        $this->assertStringContainsString('tenant_id', $migrationContent);

        $modelPath = "{$basePath}/Models/{$module}.php";
        $this->assertFileExists($modelPath);
        $this->assertStringContainsString("protected \$fillable = ['tenant_id'];", File::get($modelPath));

        $langEn = "{$basePath}/Resources/lang/en/messages.php";
        $langAr = "{$basePath}/Resources/lang/ar/messages.php";
        $this->assertFileExists($langEn);
        $this->assertFileExists($langAr);
        $this->assertStringContainsString("'example' => 'Example'", File::get($langEn));
        $this->assertStringContainsString("'example' => 'مثال'", File::get($langAr));

        $testPath = "{$basePath}/Tests/Feature/{$module}ModuleTest.php";
        $this->assertFileExists($testPath);
        $this->assertStringContainsString('namespace Modules\\'.$module.'\\Tests\\Feature;', File::get($testPath));

        $statusPath = base_path('modules_statuses.json');
        $statuses = json_decode(File::get($statusPath), true);
        $this->assertArrayHasKey($module, $statuses);
        $this->assertFalse($statuses[$module]);

        File::deleteDirectory($basePath);
        unset($statuses[$module]);
        File::put($statusPath, json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
