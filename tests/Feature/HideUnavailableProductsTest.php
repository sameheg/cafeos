<?php

namespace Tests\Feature;

use App\Product;
use App\Variation;
use App\Utils\ProductUtil;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HideUnavailableProductsTest extends TestCase
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

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->boolean('enable_stock')->default(1);
            $table->integer('unit_id')->nullable();
            $table->boolean('is_inactive')->default(0);
            $table->boolean('not_for_selling')->default(0);
        });

        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('sub_sku')->nullable();
            $table->decimal('sell_price_inc_tax', 20, 4)->default(0);
            $table->softDeletes();
        });

        Schema::create('variation_location_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variation_id');
            $table->integer('location_id')->nullable();
            $table->decimal('qty_available', 20, 4)->default(0);
        });

        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name');
        });

        Schema::create('product_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('location_id');
        });

        DB::table('units')->insert(['id' => 1, 'short_name' => 'u']);

        $availableProduct = Product::create([
            'business_id' => 1,
            'name' => 'Available',
            'type' => 'single',
            'unit_id' => 1,
        ]);
        Variation::create([
            'product_id' => $availableProduct->id,
            'name' => 'V1',
            'sub_sku' => 'S1',
            'sell_price_inc_tax' => 10,
        ]);
        DB::table('variation_location_details')->insert([
            'variation_id' => 1,
            'location_id' => 1,
            'qty_available' => 5,
        ]);
        DB::table('product_locations')->insert([
            'product_id' => $availableProduct->id,
            'location_id' => 1,
        ]);

        $unavailableProduct = Product::create([
            'business_id' => 1,
            'name' => 'Unavailable',
            'type' => 'single',
            'unit_id' => 1,
        ]);
        Variation::create([
            'product_id' => $unavailableProduct->id,
            'name' => 'V2',
            'sub_sku' => 'S2',
            'sell_price_inc_tax' => 10,
        ]);
        DB::table('variation_location_details')->insert([
            'variation_id' => 2,
            'location_id' => 2,
            'qty_available' => 5,
        ]);
        DB::table('product_locations')->insert([
            'product_id' => $unavailableProduct->id,
            'location_id' => 1,
        ]);
    }

    public function test_shows_unavailable_products_by_default()
    {
        $util = new ProductUtil();

        $results = $util->filterProduct(1, '', 1, null, null, [], [], false);

        $this->assertEqualsCanonicalizing([1, 2], $results->pluck('product_id')->all());
    }

    public function test_hides_unavailable_products_when_config_enabled()
    {
        config(['inventory.hide_unavailable' => true]);

        $util = new ProductUtil();

        $results = $util->filterProduct(1, '', 1, null, null, [], [], false);

        $this->assertEquals([1], $results->pluck('product_id')->all());
    }
}

