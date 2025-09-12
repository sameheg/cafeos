<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ar_assets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('item_id')->index();
            $table->string('url');
            $table->enum('type', ['ar', 'vr']);
            $table->string('state')->default('loaded');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ar_assets');
    }
};
