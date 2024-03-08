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
        Schema::create('tag_on_items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100);
            $table->bigInteger('item_id');
            $table->bigInteger('tag_id');
            $table->timestamps();

            $table->index('item_id');
            $table->index('tag_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_on_items');
    }
};
