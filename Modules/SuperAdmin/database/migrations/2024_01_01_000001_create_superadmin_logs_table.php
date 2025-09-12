<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('superadmin_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('action');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('timestamp');
            $table->json('meta')->nullable();
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('superadmin_logs');
    }
};
