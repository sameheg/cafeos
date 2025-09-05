<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forecasted_demands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->decimal('forecast_quantity', 22, 4)->default(0);
            $table->timestamps();

            $table->index('business_id');
            $table->index('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forecasted_demands');
    }
};
