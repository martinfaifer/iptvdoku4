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
        Schema::create('channel_programer_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels');
            $table->foreignId('channel_programmer_id')->constrained('channel_programers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_programer_channels');
    }
};
