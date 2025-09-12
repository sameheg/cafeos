<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pms_syncs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('folio_id')->constrained('pms_folios')->cascadeOnDelete();
            $table->string('external_id');
            $table->timestamps();
            $table->index('folio_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pms_syncs');
    }
};
