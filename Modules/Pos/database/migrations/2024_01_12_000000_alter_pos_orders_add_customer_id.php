<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->foreignUlid('customer_id')->nullable()->constrained('pos_customers')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });
    }
};
