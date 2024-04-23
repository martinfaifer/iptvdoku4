<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restart_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels');
            $table->string('ip_id')->unique();
            $table->foreignId('device_id')->constrained('devices');
            $table->timestamps();

            $table->index('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restart_channels');
    }
};
