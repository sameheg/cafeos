<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Core\Events\TenantCreated;
use Tests\TestCase;

class TenantApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_and_create_tenants(): void
    {
        Event::fake();

        $response = $this->postJson('/v1/tenants', ['name' => 'Alpha', 'slug' => 'alpha'])
            ->assertCreated();

        $response->assertJsonPath('tenant.slug', 'alpha');

        Event::assertDispatched(TenantCreated::class);

        $this->getJson('/v1/tenants')
            ->assertJsonFragment(['slug' => 'alpha']);
    }
}
