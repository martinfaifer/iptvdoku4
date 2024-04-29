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
        Schema::create('sftp_servers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('url')->unique();
            $table->string('username');
            $table->string('password');
            $table->longText('path_to_folder')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sftp_servers');
    }
};
