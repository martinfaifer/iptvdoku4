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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->foreignId('device_category_id')->constrained('device_categories');
            $table->foreignId('device_vendor_id')->constrained('device_vendors');
            $table->string('ip', 100)->unique()->nullable();
            $table->string('controller_ip', 100)->nullable();
            $table->string('username', 150)->nullable();
            $table->string('password')->nullable();
            $table->string('zbx_id')->nullable();
            $table->string('zbx_status', 100)->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('ip');
            $table->index('controller_ip');
            $table->index('zbx_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
