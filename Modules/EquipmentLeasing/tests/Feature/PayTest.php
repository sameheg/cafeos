<?php

namespace Modules\EquipmentLeasing\Tests\Feature;

use Illuminate\Support\Str;
use Modules\EquipmentLeasing\Models\EquipmentListing;
use Modules\EquipmentLeasing\Providers\EquipmentLeasingServiceProvider;
use Tests\TestCase;

class PayTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $provider = new EquipmentLeasingServiceProvider($this->app);
        $provider->register();
        $provider->boot();
    }

    public function test_can_create_lease(): void
    {
        $listing = EquipmentListing::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Bulldozer',
            'available' => true,
        ]);

        $response = $this->postJson('/v1/equipment/leases', [
            'equipment_id' => $listing->id,
        ]);

        $response->assertStatus(200)->assertJsonStructure(['lease_id']);
    }
}

