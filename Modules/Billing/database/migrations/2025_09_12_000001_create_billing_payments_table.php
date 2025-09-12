<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('invoice_id')->constrained('billing_invoices');
            $table->string('method');
            $table->enum('status', ['success', 'failed']);
            $table->timestamps();
            $table->index('invoice_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_payments');
    }
};
