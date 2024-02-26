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
        Schema::create('channel_multicasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels');
            $table->string('stb_ip')->unique()->nullable();
            $table->string('source_ip')->nullable();
            $table->foreignId('channel_source_id')->constrained('channel_sources');
            $table->boolean('is_backup')->default(false);
            $table->string('devices_id')->nullable();
            $table->string('status', 100)->nullable();
            $table->timestamps();

            $table->index('stb_ip');
            $table->index('source_ip');
            $table->index('is_backup');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_multicasts');
    }
};
