<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_thresholds', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('metric')->index();
            $table->decimal('min', 10, 2);
            $table->decimal('max', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_thresholds');
    }
};
