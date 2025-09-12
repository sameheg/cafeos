<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('superadmin_flags', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('module');
            $table->uuid('tenant_id')->nullable()->index();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->index(['module', 'tenant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('superadmin_flags');
    }
};
