<?php

namespace Tests;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Nwidart\Modules\Facades\Module;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase {
        refreshDatabase as baseRefreshDatabase;
    }

    protected function refreshDatabase()
    {
        foreach (Module::all() as $module) {
            $module->register();
        }

        $this->baseRefreshDatabase();

        static $migrated = false;

        foreach (Module::all() as $module) {
            if (! $migrated) {
                \Artisan::call('migrate', [
                    '--path' => $module->getPath().'/database/migrations',
                    '--realpath' => true,
                ]);
            }

            $module->boot();
        }

        $migrated = true;
    }

    protected function setUp(): void
    {
        parent::setUp();
        app()->instance('tenant', new Tenant(['id' => 1]));
    }
}
