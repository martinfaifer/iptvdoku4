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
        Schema::create('satelit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('satelit_card_vendor_id')->constrained('satelit_card_vendors');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->index('name');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satelit_cards');
    }
};
