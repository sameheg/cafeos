<?php

namespace Modules\SuperAdmin\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Modules\SuperAdmin\Providers\SuperAdminServiceProvider;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $provider = $this->app->register(SuperAdminServiceProvider::class);
        $provider->boot();
        Artisan::call('migrate', [
            '--path' => 'Modules/SuperAdmin/database/migrations',
            '--realpath' => true,
            '--database' => 'sqlite',
        ]);
    }
}
