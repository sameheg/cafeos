<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_sync_tokens', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('device_id')->index();
            $table->string('last_token')->nullable(); // incremental cursor for changes
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_sync_tokens'); }
};
