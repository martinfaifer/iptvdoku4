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
        Schema::create('genius_tv_charts', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->integer('value')->default(0);
            $table->timestamps();

            $table->index('item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genius_tv_charts');
    }
};
