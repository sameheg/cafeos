<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('foodsafety_actions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('log_id');
            $table->text('action');
            $table->timestamps();
            $table->index('log_id');
            $table->foreign('log_id')->references('id')->on('foodsafety_logs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foodsafety_actions');
    }
};
