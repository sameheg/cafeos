<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ar_interactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('asset_id')->index();
            $table->dateTime('timestamp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ar_interactions');
    }
};
