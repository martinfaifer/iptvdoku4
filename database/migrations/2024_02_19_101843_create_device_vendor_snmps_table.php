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
        Schema::create('device_vendor_snmps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_vendor_id')->constrained('device_vendors');
            $table->string('oid');
            $table->string('description');
            $table->string('human_description');
            $table->string('type');
            $table->string('interface')->nullable();
            $table->integer('interface_number')->nullable();
            $table->boolean('can_chart')->default(false);
            $table->timestamps();

            $table->index('oid');
            $table->index('type');
            $table->index('description');
            $table->index('interface');
            $table->index('can_chart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_vendor_snmps');
    }
};
