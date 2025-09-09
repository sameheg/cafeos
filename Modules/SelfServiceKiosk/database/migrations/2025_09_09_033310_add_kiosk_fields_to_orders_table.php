<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_type', ['drive_thru', 'takeaway'])->nullable();
            $table->unsignedInteger('queue_number')->nullable();
            $table->index('order_type');
            $table->index('queue_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_type']);
            $table->dropIndex(['queue_number']);
            $table->dropColumn(['order_type', 'queue_number']);
        });
    }
};
