<?php

namespace Tests;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase {
        refreshDatabase as baseRefreshDatabase;
    }

    protected function refreshDatabase()
    {
        foreach (Module::allEnabled() as $module) {
            $module->register();
        }

        $this->baseRefreshDatabase();

        static $migrated = [];

        foreach (Module::allEnabled() as $module) {
            if (! in_array($module->getName(), $migrated, true)) {
                Artisan::call('migrate', [
                    '--path' => $module->getPath().'/database/migrations',
                    '--realpath' => true,
                ]);

                $migrated[] = $module->getName();
            }

            $module->boot();
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        app()->instance('tenant', new Tenant(['id' => 1]));
    }
}
