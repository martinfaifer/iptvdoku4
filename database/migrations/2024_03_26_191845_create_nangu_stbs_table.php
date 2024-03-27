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
        Schema::create('nangu_stbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nangu_stb_accountCode_id')->constrained('nangu_stb_account_codes');
            $table->string('stb');
            $table->timestamps();

            $table->index('stb');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nangu_stbs');
    }
};
