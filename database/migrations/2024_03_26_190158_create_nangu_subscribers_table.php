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
        Schema::create('nangu_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('subscriberCode');
            $table->foreignId('nangu_isp_id')->constrained('nangu_isps');
            $table->timestamps();

            $table->index('subscriberCode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nangu_subscribers');
    }
};
