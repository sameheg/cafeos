<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('product_id');

            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('business_id')->index();
            $table->string('type');
            $table->string('message');
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('business_id')->references('id')->on('businesses');
            $table->unique(['product_id', 'type', 'business_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_alerts');
    }
};
