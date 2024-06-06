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
        Schema::create('ips', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address');
            $table->string('mask')->nullable();
            $table->integer('cidr');
            $table->string('ip_cidr_hash');
            $table->foreignId('nangu_isp_id')->nullable()->constrained('nangu_isps')->nullOnDelete();
            $table->timestamps();

            $table->index('nangu_isp_id');
            $table->index('ip_cidr_hash');
            $table->index('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ips');
    }
};
