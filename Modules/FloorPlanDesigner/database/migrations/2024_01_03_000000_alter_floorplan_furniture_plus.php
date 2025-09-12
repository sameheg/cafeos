<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('floorplan_furniture', function (Blueprint $table) {
            $table->string('qr_url')->nullable()->after('pos_table_id');
            $table->string('branch_id')->nullable()->after('tenant_id');
            $table->integer('floor_number')->default(0)->after('branch_id');
        });
    }
    public function down(): void
    {
        Schema::table('floorplan_furniture', function (Blueprint $table) {
            $table->dropColumn(['qr_url','branch_id','floor_number']);
        });
    }
};
