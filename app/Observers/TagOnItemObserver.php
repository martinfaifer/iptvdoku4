<?php

namespace App\Observers;

use App\Jobs\AddChannelToNanguPackageJob;
use App\Jobs\DeleteChannelToNanguPackageJob;
use App\Models\Channel;
use App\Models\NanguIspTagToChannelPackage;
use App\Models\TagOnItem;

class TagOnItemObserver
{
    public function created(TagOnItem $tagOnItem): void
    {
        // launch action for tags
        if (NanguIspTagToChannelPackage::where('tag_id', $tagOnItem->tag_id)->first()) {
            // existuje vazba štítek vs NanguIsp vs Programový balíček
            NanguIspTagToChannelPackage::where('tag_id', $tagOnItem->tag_id)->get()->each(function ($nanguIspTagToChannelPackage) use ($tagOnItem) {
                $channel = Channel::find($tagOnItem->item_id);
                AddChannelToNanguPackageJob::dispatch(
                    $nanguIspTagToChannelPackage->nangu_channel_package_name,
                    $channel->nangu_channel_code,
                    $nanguIspTagToChannelPackage->nangu_isp->nangu_isp_id
                );
            });
        }
    }

    public function updated(): void
    {
        //
    }

    public function deleted(TagOnItem $tagOnItem): void
    {
        if (NanguIspTagToChannelPackage::where('tag_id', $tagOnItem->tag_id)->first()) {
            // existuje vazba štítek vs NanguIsp vs Programový balíček
            NanguIspTagToChannelPackage::where('tag_id', $tagOnItem->tag_id)->get()->each(function ($nanguIspTagToChannelPackage) use ($tagOnItem) {
                $channel = Channel::find($tagOnItem->item_id);
                DeleteChannelToNanguPackageJob::dispatch(
                    $nanguIspTagToChannelPackage->nangu_channel_package_name,
                    $channel->nangu_channel_code,
                    $nanguIspTagToChannelPackage->nangu_isp->nangu_isp_id
                );
            });
        }
    }
}
