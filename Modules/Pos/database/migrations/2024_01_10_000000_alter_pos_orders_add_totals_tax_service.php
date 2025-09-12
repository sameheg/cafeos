<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->decimal('subtotal', 12, 2)->default(0)->after('status');
            $table->decimal('tax_percent', 5, 2)->default(0)->after('subtotal');
            $table->decimal('service_percent', 5, 2)->default(0)->after('tax_percent');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('service_percent');
            $table->decimal('service_amount', 12, 2)->default(0)->after('tax_amount');
            $table->decimal('discount_total', 12, 2)->default(0)->after('service_amount');
            $table->decimal('total', 12, 2)->default(0)->after('discount_total');
            $table->decimal('paid_total', 12, 2)->default(0)->after('total');
            $table->decimal('outstanding_total', 12, 2)->default(0)->after('paid_total');
            $table->string('currency')->default('EGP')->after('outstanding_total');
        });
        Schema::table('pos_items', function (Blueprint $table) {
            if (!Schema::hasColumn('pos_items','kitchen_status')) {
                $table->string('kitchen_status')->default('pending'); // pending, preparing, ready, served, void
            }
        });
    }
    public function down(): void {
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal','tax_percent','service_percent','tax_amount','service_amount','discount_total','total','paid_total','outstanding_total','currency']);
        });
        Schema::table('pos_items', function (Blueprint $table) {
            if (Schema::hasColumn('pos_items','kitchen_status')) {
                $table->dropColumn('kitchen_status');
            }
        });
    }
};
