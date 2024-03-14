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
        Schema::create('css_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color', 100)->unique();
            $table->string('hex', 100)->unique();
            $table->timestamps();

            $table->index('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('css_colors');
    }
};
