<?php

namespace Modules\Pos\Tests\Feature;

use Tests\TestCase;
use Modules\Pos\Models\MenuItem;
use App\Http\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\SetUserLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            InitializeTenancyByDomain::class,
            SetUserLocale::class,
        ]);

        $user = User::factory()->create(['tenant_id' => 1]);
        $this->actingAs($user);
    }

    public function test_store_creates_menu_item(): void
    {
        $response = $this->postJson('/pos', [
            'tenant_id' => 1,
            'name' => 'Coffee',
            'price' => 3.5,
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => __('pos::created')]);

        $this->assertDatabaseHas('menu_items', [
            'name' => 'Coffee',
            'price' => 3.5,
        ]);
    }

    public function test_update_updates_menu_item(): void
    {
        $item = MenuItem::create([
            'tenant_id' => 1,
            'name' => 'Tea',
            'price' => 2.0,
        ]);

        $response = $this->putJson("/pos/{$item->id}", [
            'name' => 'Green Tea',
            'price' => 2.5,
        ]);

        $response->assertOk();
        $response->assertJson(['message' => __('pos::updated')]);

        $this->assertDatabaseHas('menu_items', [
            'id' => $item->id,
            'name' => 'Green Tea',
            'price' => 2.5,
        ]);
    }

    public function test_destroy_deletes_menu_item(): void
    {
        $item = MenuItem::create([
            'tenant_id' => 1,
            'name' => 'Cake',
            'price' => 4.0,
        ]);

        $response = $this->deleteJson("/pos/{$item->id}");

        $response->assertOk();
        $response->assertJson(['message' => __('pos::deleted')]);

        $this->assertSoftDeleted('menu_items', ['id' => $item->id]);
    }
}

