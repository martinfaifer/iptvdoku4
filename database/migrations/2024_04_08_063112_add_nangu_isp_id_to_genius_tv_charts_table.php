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
        Schema::table('genius_tv_charts', function (Blueprint $table) {
            $table->foreignId('nangu_isp_id')->nullable()->constrained('nangu_isps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genius_tv_charts', function (Blueprint $table) {
            //
        });
    }
};
