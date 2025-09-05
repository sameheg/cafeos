<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Product;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Tests\TestCase;

class ProductQuantityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('tax')->nullable();
            $table->string('type')->nullable();
            $table->string('barcode_type')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('alert_quantity', 22, 4)->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('weight', 22, 4)->nullable();
            $table->text('product_description')->nullable();
            $table->text('sub_unit_ids')->nullable();
            $table->integer('preparation_time_in_minutes')->nullable();
            for ($i = 1; $i <= 20; $i++) {
                $table->string('product_custom_field' . $i)->nullable();
            }
            $table->integer('business_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('enable_stock')->default(0);
            $table->boolean('not_for_selling')->default(0);
            $table->string('image')->nullable();
            $table->integer('warranty_id')->nullable();
            $table->decimal('total_qty_available', 22, 4)->default(0);
            $table->timestamps();
        });

        Schema::create('product_variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('name')->nullable();
            $table->boolean('is_dummy')->default(0);
            $table->timestamps();
        });

        Schema::create('variations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('product_variation_id');
            $table->string('name')->nullable();
            $table->string('sub_sku')->nullable();
            $table->decimal('default_purchase_price', 22, 4)->default(0);
            $table->decimal('dpp_inc_tax', 22, 4)->default(0);
            $table->decimal('profit_percent', 22, 4)->default(0);
            $table->decimal('default_sell_price', 22, 4)->default(0);
            $table->decimal('sell_price_inc_tax', 22, 4)->default(0);
            $table->text('combo_variations')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropAllTables();
        Mockery::close();
        parent::tearDown();
    }

    public function test_total_qty_available_saved_on_create_and_update()
    {
        Event::fake();

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('can')->andReturn(true);
        $user->shouldReceive('permitted_locations')->andReturn('all');
        $this->be($user);

        $moduleUtil = Mockery::mock(ModuleUtil::class);
        $moduleUtil->shouldReceive('isQuotaAvailable')->andReturn(true);
        $moduleUtil->shouldReceive('getModuleData')->andReturn([]);
        $moduleUtil->shouldReceive('getModuleFormField')->andReturn([]);

        $controller = new ProductController(new ProductUtil(), $moduleUtil);

        $request = Request::create('/products', 'POST', [
            'name' => 'Test',
            'unit_id' => 1,
            'type' => 'single',
            'sku' => 'SKU1',
            'barcode_type' => 'C128',
            'alert_quantity' => 0,
            'tax_type' => 'exclusive',
            'enable_stock' => 1,
            'single_dpp' => 0,
            'single_dpp_inc_tax' => 0,
            'profit_percent' => 0,
            'single_dsp' => 0,
            'single_dsp_inc_tax' => 0,
            'product_variation' => [
                ['variations' => [
                    ['qty_available' => 2],
                    ['qty_available' => 3],
                ]]
            ],
        ]);

        $session = new Store('test', new MockArraySessionStorage());
        $request->setLaravelSession($session);
        $request->session()->put('user.business_id', 1);
        $request->session()->put('user.id', 1);
        $request->session()->put('business.enable_product_expiry', 0);
        $request->session()->put('financial_year.start', '2020-01-01');

        $controller->saveQuickProduct($request);

        $product = Product::first();
        $this->assertEquals(5, $product->total_qty_available);

        $updateRequest = Request::create('/products/1', 'PUT', [
            'name' => 'Test',
            'unit_id' => 1,
            'type' => 'single',
            'sku' => 'SKU1',
            'barcode_type' => 'C128',
            'alert_quantity' => 0,
            'tax_type' => 'exclusive',
            'enable_stock' => 1,
            'single_variation_id' => 1,
            'single_dpp' => 0,
            'single_dpp_inc_tax' => 0,
            'profit_percent' => 0,
            'single_dsp' => 0,
            'single_dsp_inc_tax' => 0,
            'product_variation' => [
                ['variations' => [
                    ['qty_available' => 4],
                ]],
            ],
        ]);

        $updateRequest->setLaravelSession($session);
        $controller->update($updateRequest, $product->id);

        $product->refresh();
        $this->assertEquals(4, $product->total_qty_available);
    }
}
