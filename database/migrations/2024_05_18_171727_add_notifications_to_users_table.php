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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notify_if_channel_change')->default(false);
            $table->boolean('notify_if_added_new_wiki_content')->default(false);
            $table->boolean('notify_if_weather_problem')->default(false);
            $table->boolean('notify_if_too_many_channels_down')->default(false);
            $table->boolean('notify_if_satelit_card_has_expiration')->default(false);
            $table->boolean('notify_if_added_new_event')->default(false);
            $table->boolean('notify_if_upload_new_banner')->default(false);
            $table->boolean('notify_if_channel_was_added_to_promo')->default(false);

            $table->index('notify_if_channel_change');
            $table->index('notify_if_added_new_wiki_content');
            $table->index('notify_if_weather_problem');
            $table->index('notify_if_too_many_channels_down');
            $table->index('notify_if_satelit_card_has_expiration');
            $table->index('notify_if_added_new_event');
            $table->index('notify_if_upload_new_banner');
            $table->index('notify_if_channel_was_added_to_promo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
