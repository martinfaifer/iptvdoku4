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
        Schema::create('nangu_isp_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nangu_isp_id')->constrained('nangu_isps');
            $table->string('invoice');
            $table->string('path');
            $table->timestamps();

            $table->index('invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nangu_isp_invoices');
    }
};
