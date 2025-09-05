<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_settings', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2)->unique();
            $table->boolean('qr_enabled')->default(false);
            $table->boolean('einvoice_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_settings');
    }
};
