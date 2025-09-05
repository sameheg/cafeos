<?php

namespace Tests\Unit;

use App\Services\Inventory\DemandForecastService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class DemandForecastServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->nullable();
            $table->string('name');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->nullable();
            $table->string('type');
            $table->string('status');
            $table->date('transaction_date');
        });

        Schema::create('transaction_sell_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('product_id');
            $table->decimal('quantity', 22, 4);
        });

        Schema::create('forecasted_demands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->nullable();
            $table->unsignedInteger('product_id');
            $table->decimal('forecast_quantity', 22, 4)->default(0);
            $table->timestamps();
        });

        DB::table('products')->insert(['id' => 1, 'business_id' => 1, 'name' => 'Coffee']);

        $date = Carbon::now()->subDays(5)->toDateString();
        DB::table('transactions')->insert([
            'id' => 1,
            'business_id' => 1,
            'type' => 'sell',
            'status' => 'final',
            'transaction_date' => $date,
        ]);

        DB::table('transaction_sell_lines')->insert([
            'transaction_id' => 1,
            'product_id' => 1,
            'quantity' => 10,
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropAllTables();
        parent::tearDown();
    }

    public function test_generate_returns_forecast()
    {
        $service = new DemandForecastService();
        $forecast = $service->generate();

        $this->assertEquals(10, $forecast[1]);
    }

    public function test_update_forecasted_demands_table()
    {
        $service = new DemandForecastService();
        $service->updateForecastedDemands();

        $record = DB::table('forecasted_demands')->where('product_id', 1)->first();
        $this->assertNotNull($record);
        $this->assertEquals(10, (float) $record->forecast_quantity);
    }
}
