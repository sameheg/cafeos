<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('external_id');
            $table->string('provider');
            $table->string('status');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamps();

            $table->unique(['external_id', 'provider']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_orders');
    }
};
