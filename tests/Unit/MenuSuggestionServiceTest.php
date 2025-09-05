<?php

namespace Tests\Unit;

use App\Services\MenuSuggestionService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Mockery;
use OpenAI\Laravel\Facades\OpenAI;
use Tests\TestCase;

class MenuSuggestionServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        config()->set('cache.default', 'array');

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('transaction_sell_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->decimal('quantity', 22, 4);
        });

        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Burger'],
            ['id' => 2, 'name' => 'Pizza'],
        ]);

        DB::table('transaction_sell_lines')->insert([
            ['product_id' => 1, 'quantity' => 5],
            ['product_id' => 2, 'quantity' => 10],
        ]);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_service_returns_cached_suggestions()
    {
        $clientMock = Mockery::mock();
        $clientMock->shouldReceive('create')
            ->once()
            ->andReturn(['choices' => [['text' => "Soup\nSalad"]]]);

        OpenAI::shouldReceive('completions')
            ->once()
            ->andReturn($clientMock);

        $service = new MenuSuggestionService();
        $first = $service->getSuggestions();
        $second = $service->getSuggestions();

        $this->assertEquals(['Soup', 'Salad'], $first);
        $this->assertEquals($first, $second);
    }
}
