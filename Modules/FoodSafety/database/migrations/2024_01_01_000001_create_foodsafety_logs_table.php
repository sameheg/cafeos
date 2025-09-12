<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('foodsafety_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('item_id');
            $table->decimal('temp', 5, 2);
            $table->dateTime('timestamp');
            $table->string('status')->default('monitored');
            $table->timestamps();
            $table->index(['tenant_id', 'timestamp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foodsafety_logs');
    }
};
