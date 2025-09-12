<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dashboard_cache', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('key')->index();
            $table->json('value');
            $table->timestamp('expiry')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_cache');
    }
};
