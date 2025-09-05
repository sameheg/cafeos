<?php

namespace Tests\Feature;

use App\Tenant;
use App\User;
use App\Http\Middleware\SetTenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_are_isolated_by_tenant()
    {
        $tenantOne = Tenant::factory()->create(['slug' => 'alpha']);
        $tenantTwo = Tenant::factory()->create(['slug' => 'beta']);

        app()->instance('tenant', $tenantOne);
        User::create([
            'surname' => 'A',
            'first_name' => 'Alice',
            'username' => 'alice',
            'password' => bcrypt('secret'),
        ]);

        app()->instance('tenant', $tenantTwo);
        User::create([
            'surname' => 'B',
            'first_name' => 'Bob',
            'username' => 'bob',
            'password' => bcrypt('secret'),
        ]);

        Route::middleware(SetTenant::class)->get('/users', function () {
            return User::pluck('username');
        });

        $this->get('/users', ['X-Tenant' => 'alpha'])
            ->assertExactJson(['alice']);

        $this->get('/users', ['X-Tenant' => 'beta'])
            ->assertExactJson(['bob']);
    }
}
