<?php

namespace Tests\Feature;

use App\Tenant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        app()->instance('tenant', $tenantOne);
        $this->assertEquals(1, User::count());
        $this->assertEquals('alice', User::first()->username);

        app()->instance('tenant', $tenantTwo);
        $this->assertEquals(1, User::count());
        $this->assertEquals('bob', User::first()->username);
    }
}
