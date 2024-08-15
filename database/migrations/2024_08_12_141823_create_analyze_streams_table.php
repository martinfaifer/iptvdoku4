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
        Schema::create('analyze_streams', function (Blueprint $table) {
            $table->id();
            $table->string('stream_url');
            $table->longText('analyze');
            $table->timestamps();

            $table->index('stream_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyze_streams');
    }
};
