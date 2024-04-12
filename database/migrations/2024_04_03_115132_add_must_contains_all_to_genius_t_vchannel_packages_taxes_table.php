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
        Schema::table('genius_t_vchannel_packages_taxes', function (Blueprint $table) {
            $table->boolean('must_contains_all')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genius_t_vchannel_packages_taxes', function (Blueprint $table) {
            //
        });
    }
};
