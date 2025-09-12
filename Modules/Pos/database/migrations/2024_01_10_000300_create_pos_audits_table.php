<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_audits', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->string('user_id')->nullable();
            $table->string('action'); // discount.applied, order.void, refund.created, etc.
            $table->string('entity_type'); // order, item, payment, refund
            $table->string('entity_id');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_audits'); }
};
