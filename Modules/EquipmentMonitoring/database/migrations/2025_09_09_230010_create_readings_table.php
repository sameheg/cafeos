<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->cascadeOnDelete();
            $table->float('temperature')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
