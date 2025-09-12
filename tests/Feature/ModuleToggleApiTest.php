<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ModuleToggleController;
use Modules\Core\Events\JsonDomainEvent;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class ModuleToggleApiTest extends TestCase
{
    public function test_module_can_be_toggled_via_api(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);
        app()->instance('tenant', $tenant);
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
            'tenant_id' => $tenant->id,
        ]);

        Event::fake();

        $controller = new ModuleToggleController();
        $request = Request::create('/api/v1/admin/modules/inventory', 'PATCH', ['enabled' => true]);
        $response = $controller->update($request, 'inventory');

        $this->assertEquals(200, $response->status());

        $this->assertDatabaseHas('feature_flags', [
            'tenant_id' => $tenant->id,
            'name' => 'inventory',
            'enabled' => true,
        ]);

        Event::assertDispatched(JsonDomainEvent::class, function ($event) {
            return $event->event === 'admin.module.toggled@v1'
                && $event->data['module'] === 'inventory'
                && $event->data['enabled'] === true;
        });
    }
}
