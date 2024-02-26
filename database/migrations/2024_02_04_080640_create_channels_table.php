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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('logo')->unique()->nullable();
            $table->boolean('is_radio')->default(false);
            $table->boolean('is_multiscreen')->default(true);
            $table->string('quality');
            $table->string('category');
            $table->longText('description')->nullable();
            $table->string('nangu_chunk_store_id')->nullable();
            $table->string('nangu_channel_code')->nullable()->unique();
            $table->timestamps();

            $table->index('name');
            $table->index('is_radio');
            $table->index('is_multiscreen');
            $table->index('quality');
            $table->index('category');
            $table->index('nangu_chunk_store_id');
            $table->index('nangu_channel_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
