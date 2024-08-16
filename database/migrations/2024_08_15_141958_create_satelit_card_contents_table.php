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
        Schema::create('satelit_card_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('satelit_card_id')->constrained('satelit_cards');
            $table->string('file_name');
            $table->string('path');
            $table->timestamps();

            $table->index('file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satelit_card_contents');
    }
};
