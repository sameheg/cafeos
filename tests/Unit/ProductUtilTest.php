<?php

namespace Tests\Unit;

use App\Utils\ProductUtil;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Mockery;

class ProductUtilTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name')->nullable();
        });
        Schema::create('business_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('business_id')->nullable();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('unit_id')->nullable();
            $table->string('type')->nullable();
            $table->decimal('alert_quantity', 22, 4)->default(0);
            $table->boolean('enable_stock')->default(1);
            $table->integer('business_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('not_for_selling')->default(0);
            $table->boolean('is_inactive')->default(0);
            $table->integer('brand_id')->nullable();
            $table->string('product_custom_field1')->nullable();
            $table->string('product_custom_field2')->nullable();
            $table->string('product_custom_field3')->nullable();
            $table->string('product_custom_field4')->nullable();
        });
        Schema::create('product_variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->string('name')->nullable();
        });
        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->integer('product_variation_id')->nullable();
            $table->string('name')->nullable();
            $table->decimal('sell_price_inc_tax', 22, 4)->default(0);
            $table->string('sub_sku')->nullable();
        });
        Schema::create('variation_location_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variation_id');
            $table->integer('location_id');
            $table->decimal('qty_available', 22, 4)->default(0);
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->integer('location_id')->nullable();
        });
        Schema::create('transaction_sell_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->nullable();
            $table->integer('variation_id')->nullable();
            $table->decimal('quantity', 22, 4)->default(0);
            $table->decimal('quantity_returned', 22, 4)->default(0);
        });
        Schema::create('stock_adjustment_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->nullable();
            $table->integer('variation_id')->nullable();
            $table->decimal('quantity', 22, 4)->default(0);
        });
        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->nullable();
            $table->integer('variation_id')->nullable();
            $table->decimal('quantity', 22, 4)->default(0);
            $table->decimal('purchase_price_inc_tax', 22, 4)->default(0);
            $table->decimal('quantity_sold', 22, 4)->default(0);
            $table->decimal('quantity_adjusted', 22, 4)->default(0);
            $table->decimal('quantity_returned', 22, 4)->default(0);
            $table->decimal('mfg_quantity_used', 22, 4)->default(0);
        });
        Schema::create('product_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('location_id');
        });
    }

    protected function tearDown(): void
    {
        Schema::dropAllTables();
        Mockery::close();
        parent::tearDown();
    }

    public function test_products_without_transactions_are_included()
    {
        DB::table('units')->insert(['id' => 1, 'short_name' => 'pcs']);
        DB::table('business_locations')->insert(['id' => 1, 'name' => 'BL', 'business_id' => 1]);
        DB::table('product_variations')->insert(['id' => 1, 'product_id' => 1, 'name' => 'PV']);
        DB::table('products')->insert([
            'id' => 1,
            'name' => 'Test',
            'unit_id' => 1,
            'type' => 'single',
            'alert_quantity' => 0,
            'enable_stock' => 1,
            'business_id' => 1,
        ]);
        DB::table('variations')->insert([
            'id' => 1,
            'product_id' => 1,
            'product_variation_id' => 1,
            'name' => 'Default',
            'sell_price_inc_tax' => 0,
            'sub_sku' => 'SKU1',
        ]);
        DB::table('variation_location_details')->insert([
            'id' => 1,
            'variation_id' => 1,
            'location_id' => 1,
            'qty_available' => 5,
        ]);

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('permitted_locations')->andReturn('all');
        $this->be($user);

        $util = new ProductUtil();
        $result = $util->getProductStockDetails(1, [], 'view_product');

        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result->first()->product_id);
    }
}
