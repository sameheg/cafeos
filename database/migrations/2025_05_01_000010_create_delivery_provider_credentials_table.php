<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_provider_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->string('token');
            $table->string('secret');
            $table->timestamps();

            $table->unique(['provider', 'business_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_provider_credentials');
    }
};
