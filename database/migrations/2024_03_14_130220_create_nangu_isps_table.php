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
        Schema::create('nangu_isps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('nangu_isp_id', 100)->unique();
            $table->boolean('is_akcionar')->default(false);
            $table->string('ic', 100)->nullable();
            $table->string('dic', 100)->nullable();
            $table->string('hbo_key', 100)->nullable();
            $table->string('crm_contract_id')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('is_akcionar');
            $table->index(['ic', 'dic']);
            $table->index('hbo_key');
            $table->index('crm_contract_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nangu_isps');
    }
};
