<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pos_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('order_id');
            $table->ulid('product_id');
            $table->integer('qty');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->index('order_id');
            $table->foreign('order_id')->references('id')->on('pos_orders')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_items');
    }
};
