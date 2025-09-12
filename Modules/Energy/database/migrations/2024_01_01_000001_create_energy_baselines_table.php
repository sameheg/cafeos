<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_baselines', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('period');
            $table->decimal('value', 10, 2);
            $table->index('period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_baselines');
    }
};
