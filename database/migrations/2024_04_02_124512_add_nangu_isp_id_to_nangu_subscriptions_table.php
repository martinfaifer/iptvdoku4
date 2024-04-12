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
        Schema::table('nangu_subscriptions', function (Blueprint $table) {
            $table->foreignId('nangu_isp_id')->constrained('nangu_isps', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nangu_subscriptions', function (Blueprint $table) {
            //
        });
    }
};
