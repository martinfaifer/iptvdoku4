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
        Schema::table('sftp_servers', function (Blueprint $table) {
            $table->string('connection_type')->default('sftp');

            $table->index('connection_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sftp_servers', function (Blueprint $table) {
            //
        });
    }
};
