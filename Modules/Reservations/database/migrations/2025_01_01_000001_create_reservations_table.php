<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('table_id');
            $table->dateTime('time');
            $table->string('status');
            $table->timestamps();
            $table->index(['tenant_id', 'time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
