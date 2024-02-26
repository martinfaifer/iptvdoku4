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
        Schema::table('devices', function (Blueprint $table) {
            $table->boolean('is_snmp')->default(false);
            $table->string('snmp_version', 50)->nullable();
            $table->string('snmp_private_comunity')->nullable();
            $table->string('snmp_public_comunity')->nullable();

            $table->longText('template')->nullable();

            $table->index('is_snmp');
            $table->index('snmp_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            //
        });
    }
};
