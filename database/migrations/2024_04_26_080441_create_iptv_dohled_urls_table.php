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
        Schema::create('iptv_dohled_urls', function (Blueprint $table) {
            $table->id();
            $table->string('iptv_dohled_id')->unique();
            $table->string('stream_url')->unique();
            $table->timestamps();

            $table->index('stream_url');
            $table->index('iptv_dohled_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iptv_dohled_urls');
    }
};
