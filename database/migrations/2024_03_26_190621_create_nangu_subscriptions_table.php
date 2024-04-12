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
        Schema::create('nangu_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nangu_subscriber_id')->constrained('nangu_subscribers');
            $table->string('subscriptionCode');
            $table->string('subscriptionState');
            $table->string('tariffCode')->nullable();
            $table->string('localityCode')->nullable();
            $table->longText('channelPackagesCodes')->nullable();
            $table->longText('offers')->nullable();
            $table->longText('channels')->nullable();
            $table->timestamps();

            $table->index('subscriptionCode');
            $table->index('subscriptionState');
            $table->index('tariffCode');
            $table->index('localityCode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nangu_subscriptions');
    }
};
