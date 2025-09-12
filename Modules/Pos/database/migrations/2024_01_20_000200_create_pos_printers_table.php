<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_printers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('name');
            $table->string('type')->default('escpos'); // escpos, network, usb
            $table->string('endpoint')->nullable(); // ip:port, usb path, etc.
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_printers'); }
};
