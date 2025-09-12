<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_monitoring', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('equipment_id');
            $table->string('metric');
            $table->decimal('value', 10, 2);
            $table->dateTime('timestamp');
            $table->index(['tenant_id', 'timestamp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_monitoring');
    }
};
