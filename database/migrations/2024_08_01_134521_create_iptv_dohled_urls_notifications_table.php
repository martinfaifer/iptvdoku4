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
        Schema::create('iptv_dohled_urls_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iptv_dohled_url_id');
            $table->string('email')->nullable();
            $table->string('slack_channel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iptv_dohled_urls_notifications');
    }
};
