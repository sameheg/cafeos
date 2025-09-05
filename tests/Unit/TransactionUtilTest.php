<?php

namespace Tests\Unit;

use App\Utils\TransactionUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class TransactionUtilTest extends TestCase
{
    public function test_adjust_mapping_purchase_sell_decrements_quantities()
    {
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('quantity_sold', 22, 4)->default(0);
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('transaction_sell_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
        });

        Schema::create('transaction_sell_lines_purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sell_line_id');
            $table->integer('purchase_line_id');
            $table->decimal('quantity', 22, 4);
        });

        DB::table('purchase_lines')->insert([
            ['id' => 1, 'quantity_sold' => 10],
            ['id' => 2, 'quantity_sold' => 10],
        ]);

        DB::table('transactions')->insert(['id' => 1]);
        DB::table('transaction_sell_lines')->insert([
            ['id' => 1, 'transaction_id' => 1],
            ['id' => 2, 'transaction_id' => 1],
        ]);

        DB::table('transaction_sell_lines_purchase_lines')->insert([
            ['id' => 1, 'sell_line_id' => 1, 'purchase_line_id' => 1, 'quantity' => 2],
            ['id' => 2, 'sell_line_id' => 2, 'purchase_line_id' => 1, 'quantity' => 3],
            ['id' => 3, 'sell_line_id' => 1, 'purchase_line_id' => 2, 'quantity' => 1],
        ]);

        $util = new TransactionUtil();
        $transaction = (object) ['id' => 1, 'status' => 'draft'];

        $util->adjustMappingPurchaseSell('final', $transaction, null, []);

        $this->assertEquals(5, DB::table('purchase_lines')->where('id', 1)->value('quantity_sold'));
        $this->assertEquals(9, DB::table('purchase_lines')->where('id', 2)->value('quantity_sold'));
        $this->assertEquals(0, DB::table('transaction_sell_lines_purchase_lines')->count());
    }
}
