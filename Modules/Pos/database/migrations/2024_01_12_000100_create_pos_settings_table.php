<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_settings', function (Blueprint $table) {
            $table->uuid('tenant_id')->primary();
            $table->decimal('default_tax_percent',5,2)->default(0);
            $table->decimal('default_service_percent',5,2)->default(0);
            $table->string('currency')->default('EGP');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_settings'); }
};
