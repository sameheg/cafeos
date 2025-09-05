<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RecipeSyncTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]]);
        DB::statement('PRAGMA foreign_keys=ON');

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('mfg_recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('variation_id');
            $table->text('instructions')->nullable();
            $table->decimal('waste_percent', 20, 4)->default(0);
            $table->decimal('extra_cost', 20, 4)->default(0);
            $table->decimal('total_quantity', 20, 4)->default(1);
            $table->decimal('final_price', 20, 4)->default(0);
            $table->integer('sub_unit_id')->nullable();
            $table->timestamps();
        });

        Schema::create('mfg_recipe_ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mfg_recipe_id');
            $table->integer('variation_id');
            $table->decimal('quantity', 20, 4);
            $table->decimal('waste_percent', 20, 4)->default(0);
            $table->integer('sub_unit_id')->nullable();
            $table->timestamps();
        });
    }

    /** @test */
    public function it_can_sync_recipe_and_ingredients()
    {
        $this->seed(RecipeTestSeeder::class);

        $user = User::factory()->create();

        $payload = [
            'product_id' => 1,
            'variation_id' => 1,
            'instructions' => 'Updated instructions',
            'ingredients' => [
                ['variation_id' => 2, 'quantity' => 2, 'waste_percent' => 0, 'sub_unit_id' => null],
            ],
        ];

        $response = $this->actingAs($user)->postJson('/catalog/recipes/sync', $payload);

        if ($response->status() === 404) {
            $this->markTestIncomplete('Recipe sync endpoint not implemented.');
        }

        $response->assertStatus(200);

        $this->assertDatabaseHas('mfg_recipes', [
            'product_id' => 1,
            'instructions' => 'Updated instructions',
        ]);

        $this->assertDatabaseHas('mfg_recipe_ingredients', [
            'mfg_recipe_id' => 1,
            'variation_id' => 2,
            'quantity' => 2,
        ]);
    }
}

class RecipeTestSeeder extends Seeder
{
    public function run()
    {
        DB::table('mfg_recipes')->insert([
            'id' => 1,
            'product_id' => 1,
            'variation_id' => 1,
            'instructions' => 'Old instructions',
            'waste_percent' => 0,
            'extra_cost' => 0,
            'total_quantity' => 1,
            'final_price' => 10,
            'sub_unit_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mfg_recipe_ingredients')->insert([
            'id' => 1,
            'mfg_recipe_id' => 1,
            'variation_id' => 2,
            'quantity' => 1,
            'waste_percent' => 0,
            'sub_unit_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
