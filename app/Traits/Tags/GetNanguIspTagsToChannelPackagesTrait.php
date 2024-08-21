<?php

namespace App\Traits\Tags;

use App\Models\Tag;
use App\Models\NanguIspTagToChannelPackage;

trait GetNanguIspTagsToChannelPackagesTrait
{
    public function get_nangu_isp_tags_to_channels(): array
    {
        $tags = [];
        if (NanguIspTagToChannelPackage::first()) {
            foreach (NanguIspTagToChannelPackage::distinct()->get('tag_id') as $nanguIspTagToChannelPackage) {
                $tags[] = [
                    'id' => $nanguIspTagToChannelPackage->tag_id,
                    'name' => Tag::find($nanguIspTagToChannelPackage->tag_id)->name,
                ];
            }
        }

        return $tags;
    }
}
