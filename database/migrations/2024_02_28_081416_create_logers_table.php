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
        Schema::create('logers', function (Blueprint $table) {
            $table->id();
            $table->string('user', 100);
            $table->string('type', 100);
            $table->string('item', 100);
            $table->longText('payload');
            $table->timestamps();

            $table->index('user');
            $table->index('type');
            $table->index('item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logers');
    }
};
