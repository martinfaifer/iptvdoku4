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
        Schema::table('channel_multicasts', function (Blueprint $table) {
            $table->fullText(['stb_ip', 'source_ip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('channel_multicasts', function (Blueprint $table) {
            $table->dropFullText(['stb_ip', 'source_ip']);
        });
    }
};
