<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function resolves_tenant_by_domain(): void
    {
        $tenant = Tenant::create([
            'name' => 'Foo',
            'domain' => 'foo.test',
            'database' => 'tenant_foo',
        ]);

        $response = $this->get('http://foo.test');

        $response->assertStatus(404); // no route but tenant should be resolved
        $this->assertEquals($tenant->id, tenant()->id);
    }

    /** @test */
    public function isolates_data_between_tenants(): void
    {
        $tenantA = Tenant::create(['name' => 'A', 'domain' => 'a.test', 'database' => 'tenant_a']);
        $tenantB = Tenant::create(['name' => 'B', 'domain' => 'b.test', 'database' => 'tenant_b']);

        $tenantA->makeCurrent();
        \App\Models\User::create([
            'tenant_id' => $tenantA->id,
            'name' => 'User A',
            'email' => 'a@example.com',
            'password' => 'secret',
        ]);
        $tenantA->forgetCurrent();

        $tenantB->makeCurrent();
        $this->assertDatabaseMissing('users', ['email' => 'a@example.com'], 'tenant');
        $tenantB->forgetCurrent();
    }
}
