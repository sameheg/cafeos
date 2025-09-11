<?php

namespace Tests\Feature;

use App\Http\Middleware\InitializeTenant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{

    public function test_middleware_resolves_tenant_by_domain(): void
    {
        if (file_exists(database_path('landlord.sqlite'))) {
            unlink(database_path('landlord.sqlite'));
        }
        touch(database_path('landlord.sqlite'));

        $this->artisan('migrate', [
            '--database' => 'landlord',
            '--path' => 'database/migrations/2025_01_01_create_tenants_table.php',
        ]);

        $tenant = Tenant::create([
            'name' => 'Alpha',
            'domain' => 'alpha.test',
            'database' => database_path('alpha.sqlite'),
        ]);

        $request = Request::create('http://alpha.test');
        $middleware = new InitializeTenant();
        $middleware->handle($request, fn () => null);

        $this->assertTrue($tenant->isCurrent());
    }

    public function test_data_is_isolated_between_tenants(): void
    {
        if (file_exists(database_path('landlord.sqlite'))) {
            unlink(database_path('landlord.sqlite'));
        }
        touch(database_path('landlord.sqlite'));

        $this->artisan('migrate', [
            '--database' => 'landlord',
            '--path' => 'database/migrations/2025_01_01_create_tenants_table.php',
        ]);

        $tenantA = Tenant::create([
            'name' => 'A',
            'domain' => 'a.test',
            'database' => database_path('a.sqlite'),
        ]);
        $tenantB = Tenant::create([
            'name' => 'B',
            'domain' => 'b.test',
            'database' => database_path('b.sqlite'),
        ]);

        foreach ([$tenantA, $tenantB] as $tenant) {
            if (file_exists($tenant->database)) {
                unlink($tenant->database);
            }
            touch($tenant->database);
            $tenant->makeCurrent();
            Schema::connection('tenant')->create('users', function ($table) {
                $table->id();
                $table->foreignId('tenant_id');
                $table->string('name');
                $table->string('email');
                $table->string('password');
                $table->timestamps();
            });
        }

        $tenantA->makeCurrent();
        User::create([
            'tenant_id' => $tenantA->id,
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret',
        ]);

        $tenantB->makeCurrent();
        $this->assertSame(0, User::count());
    }
}
