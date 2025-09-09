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
        $this->assertStringContainsString('tenant_id', File::get($migrationFiles[0]));

        $this->assertFileExists("{$basePath}/Models/{$module}.php");
        $this->assertFileExists("{$basePath}/Resources/lang/en/messages.php");
        $this->assertFileExists("{$basePath}/Resources/lang/ar/messages.php");
        $this->assertFileExists("{$basePath}/Tests/Feature/{$module}ModuleTest.php");

        File::deleteDirectory($basePath);
        $statusPath = base_path('modules_statuses.json');
        $statuses = json_decode(File::get($statusPath), true);
        unset($statuses[$module]);
        File::put($statusPath, json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
