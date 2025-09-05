<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kds_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->integer('prep_time_seconds')->nullable();
            $table->integer('queue_time_seconds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kds_metrics');
    }
};
