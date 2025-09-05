<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RecipeInventoryDeductionTest extends TestCase
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

        Schema::create('variation_location_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variation_id');
            $table->integer('location_id')->nullable();
            $table->decimal('qty_available', 20, 4)->default(0);
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

    private function sellProduct(int $qty): void
    {
        $recipe = DB::table('mfg_recipes')->first();
        $ingredients = DB::table('mfg_recipe_ingredients')->where('mfg_recipe_id', $recipe->id)->get();

        foreach ($ingredients as $ingredient) {
            DB::table('variation_location_details')
                ->where('variation_id', $ingredient->variation_id)
                ->decrement('qty_available', $ingredient->quantity * $qty);
        }
    }

    /** @test */
    public function it_deducts_ingredient_stock_when_recipe_product_sold()
    {
        $this->seed(RecipeInventorySeeder::class);

        $user = User::factory()->create();

        $this->sellProduct(1);

        $this->assertDatabaseHas('variation_location_details', [
            'variation_id' => 2,
            'qty_available' => 8,
        ]);
    }
}

class RecipeInventorySeeder extends Seeder
{
    public function run()
    {
        DB::table('variation_location_details')->insert([
            'id' => 1,
            'variation_id' => 2,
            'location_id' => 1,
            'qty_available' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mfg_recipes')->insert([
            'id' => 1,
            'product_id' => 1,
            'variation_id' => 1,
            'instructions' => null,
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
            'quantity' => 2,
            'waste_percent' => 0,
            'sub_unit_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
