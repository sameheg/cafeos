<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->decimal('kwh', 10, 2)->check('kwh > 0');
            $table->dateTime('logged_at');
            $table->boolean('is_anomaly')->default(false);
            $table->index(['tenant_id', 'logged_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_logs');
    }
};
