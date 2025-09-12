<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_slots', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->date('date')->index();
            $table->integer('capacity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_slots');
    }
};
