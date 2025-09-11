<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class ModuleToggleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tenant_cannot_access_disabled_module(): void
    {
        Route::get('/dummy', fn () => 'ok')->middleware('ensure-module-enabled:core');

        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a']);
        app()->instance('currentTenant', $tenant);
        $tenant->modules()->create(['module' => 'core', 'enabled' => false]);

        $this->get('/dummy')->assertForbidden();

        $tenant->modules()->update(['enabled' => true]);
        $this->get('/dummy')->assertOk();
    }
}
