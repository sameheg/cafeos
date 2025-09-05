<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('table_id');
            $table->unsignedInteger('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('placed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_orders');
    }
};
