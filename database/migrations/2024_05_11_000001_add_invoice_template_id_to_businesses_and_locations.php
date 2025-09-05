<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_template_id')->nullable()->after('id');
        });

        Schema::table('business_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_template_id')->nullable()->after('invoice_layout_id');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('invoice_template_id');
        });
        Schema::table('business_locations', function (Blueprint $table) {
            $table->dropColumn('invoice_template_id');
        });
    }
};
