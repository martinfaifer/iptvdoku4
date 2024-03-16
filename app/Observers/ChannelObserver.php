<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\Loger;
use App\Models\Channel;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Services\Api\NanguTv\ChannelsService;
use Illuminate\Support\Facades\Artisan;

class ChannelObserver
{
    public function created(Channel $channel)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::CREATED_TYPE,
            item: "channel:$channel->id",
            payload: json_encode([
                'id' => $channel->id,
                'name' => $channel->name,
                'logo' => $channel->logo,
                'is_radio' => $channel->is_radio,
                'is_multiscreen' => $channel->is_multiscreen,
                'quality' => $channel->quality,
                'category' => $channel->category,
                'description' => $channel->description,
                'nangu_chunk_store_id' => $channel->nangu_chunk_store_id,
                'nangu_channel_code' => $channel->nangu_channel_code,
                'geniustv_channel_packages_id' => $channel->geniustv_channel_packages_id,
            ])
        );

        Artisan::call('channels:get-detail-from-nangu-api');
    }

    public function updated(Channel $channel)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_TYPE,
            item: "channel:$channel->id",
            payload: json_encode([
                'id' => $channel->id,
                'name' => $channel->name,
                'logo' => $channel->logo,
                'is_radio' => $channel->is_radio,
                'is_multiscreen' => $channel->is_multiscreen,
                'quality' => $channel->quality,
                'category' => $channel->category,
                'description' => $channel->description,
                'nangu_chunk_store_id' => $channel->nangu_chunk_store_id,
                'nangu_channel_code' => $channel->nangu_channel_code,
                'geniustv_channel_packages_id' => $channel->geniustv_channel_packages_id,
            ])
        );

        Artisan::call('channels:get-detail-from-nangu-api');
    }

    public function deleted(Channel $channel)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "channel:$channel->id",
            payload: json_encode([
                'id' => $channel->id,
                'name' => $channel->name,
            ])
        );
        // delete channel contacts
        Contact::where('type', 'channel')->where('item_id', $channel->id)->delete();
    }
}
