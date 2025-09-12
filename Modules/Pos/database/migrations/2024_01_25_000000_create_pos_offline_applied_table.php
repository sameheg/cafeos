<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_offline_applied', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->string('device_id');
            $table->string('mutation_key')->unique(); // idempotency key per mutation
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_offline_applied'); }
};
