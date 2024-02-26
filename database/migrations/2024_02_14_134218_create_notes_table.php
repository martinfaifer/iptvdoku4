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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->nullable()->constrained('channels');
            $table->foreignId('h264_id')->nullable()->constrained('h264_s');
            $table->foreignId('h265_id')->nullable()->constrained('h265_s');
            $table->foreignId('device_id')->nullable()->constrained('devices');
            $table->longText('note')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();

            $table->index('channel_id');
            $table->index('h264_id');
            $table->index('h265_id');
            $table->index('device_id');
            $table->index('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
