<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dashboard_configs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('user_id')->index();
            $table->json('widgets');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_configs');
    }
};
