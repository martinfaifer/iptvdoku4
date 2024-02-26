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
        Schema::create('channel_qualities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('bitrate')->nullable();
            $table->integer('port')->nullable();
            $table->string('format', 100);
            $table->timestamps();

            $table->index('name');
            $table->index('bitrate');
            $table->index('port');
            $table->index('format');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_qualities');
    }
};
