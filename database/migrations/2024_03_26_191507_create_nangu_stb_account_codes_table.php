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
        Schema::create('nangu_stb_account_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nangu_subscription_code_id')->constrained('nangu_subscriptions');
            $table->string('stbAccountCodes');
            $table->timestamps();

            $table->index('stbAccountCodes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nangu_stb_account_codes');
    }
};
