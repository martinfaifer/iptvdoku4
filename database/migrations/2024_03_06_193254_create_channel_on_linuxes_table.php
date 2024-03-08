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
        Schema::create('channel_on_linuxes', function (Blueprint $table) {
            $table->id();
            $table->string('channel_type', 100);
            $table->foreignId('channel_id');
            $table->foreignId('device_id')->constrained('devices');
            $table->string('path');
            $table->timestamps();

            $table->index('channel_type');
            $table->index('channel_id');
            $table->index('path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_on_linuxes');
    }
};
