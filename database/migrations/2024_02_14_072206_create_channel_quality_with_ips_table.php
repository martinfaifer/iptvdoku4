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
        Schema::create('channel_quality_with_ips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('h264_id')->nullable()->constrained('h264_s');
            $table->foreignId('h265_id')->nullable()->constrained('h265_s');
            $table->foreignId('channel_quality_id')->nullable()->constrained('channel_qualities');
            $table->ipAddress('ip')->unique();
            $table->timestamps();

            $table->index('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_quality_with_ips');
    }
};
