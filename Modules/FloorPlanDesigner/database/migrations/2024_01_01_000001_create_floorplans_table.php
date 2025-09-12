<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('floorplans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->json('json_data');
            $table->integer('version');
            $table->timestamp('scheduled_at')->nullable();
            $table->string('state')->default('draft');
            $table->timestamps();
            $table->index(['tenant_id', 'version'], 'tenant_id_version');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floorplans');
    }
};
