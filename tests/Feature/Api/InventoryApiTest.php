<?php

namespace Tests\Feature\Api;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InventoryApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->integer('change');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('inventory_movements');
        parent::tearDown();
    }

    /** @test */
    public function it_records_movements()
    {
        $payload = ['item' => 'coffee_beans', 'change' => 5];

        $this->postJson('/api/inventory/movements', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('inventory_movements', $payload);
    }

    /** @test */
    public function it_returns_inventory_levels()
    {
        $this->postJson('/api/inventory/movements', ['item' => 'beans', 'change' => 5]);
        $this->postJson('/api/inventory/movements', ['item' => 'beans', 'change' => -2]);

        $response = $this->getJson('/api/inventory/levels');

        $response->assertStatus(200)
            ->assertJson([
                ['item' => 'beans', 'quantity' => 3],
            ]);
    }
}
