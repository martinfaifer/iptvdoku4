<?php

use App\Models\Channel;
use App\Models\ChannelRegion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('channel_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();

            $table->index('name');
        });

        ChannelRegion::create([
            'name' => 'cz',
        ]);

        ChannelRegion::create([
            'name' => 'sk',
        ]);

        ChannelRegion::create([
            'name' => 'czsk',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channel_regions');
    }
};
