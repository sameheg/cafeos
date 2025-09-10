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
        foreach (Module::allEnabled() as $module) {
            $module->register();
            $module->boot();
        }

        $this->baseRefreshDatabase();
    }

    protected function setUp(): void
    {
        parent::setUp();
        app()->instance('tenant', new Tenant(['id' => 1]));
    }
}
