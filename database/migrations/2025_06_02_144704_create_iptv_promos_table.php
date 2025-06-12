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
        Schema::create('iptv_promos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable()->index();
            $table->longText('locality')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('creator')->index();
            $table->string('expiration')->index();
            $table->string('subscriberCode')->index();
            $table->string('ispCode')->index();
            $table->string('subscriptionCode')->index();
            $table->string('subscriptionStbAccountCode')->index();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('identityId');
            $table->boolean('expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iptv_promos');
    }
};
