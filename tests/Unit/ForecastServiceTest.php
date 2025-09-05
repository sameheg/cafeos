<?php

namespace Tests\Unit;

use Modules\Reporting\Services\ForecastService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ForecastServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->decimal('final_total', 22, 4);
        });

        Schema::create('variation_location_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('qty_available', 22, 4);
        });

        DB::table('transactions')->insert([
            ['type' => 'sell', 'final_total' => 200],
            ['type' => 'sell', 'final_total' => 100],
        ]);

        DB::table('variation_location_details')->insert([
            ['qty_available' => 150],
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropAllTables();
        parent::tearDown();
    }

    public function test_forecast_calculation(): void
    {
        $service = new ForecastService();
        $result = $service->forecast();

        $this->assertEquals(300, (float) $result['sales']);
        $this->assertEquals(150, (float) $result['inventory']);
        $this->assertEquals(0.5, $result['forecast']);
    }

    public function test_forecast_with_zero_sales(): void
    {
        DB::table('transactions')->delete();

        $service = new ForecastService();
        $result = $service->forecast();

        $this->assertEquals(0, (float) $result['sales']);
        $this->assertEquals(150, (float) $result['inventory']);
        $this->assertEquals(0, $result['forecast']);
    }
}
