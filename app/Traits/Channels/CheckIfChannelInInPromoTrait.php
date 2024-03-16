<?php

namespace App\Traits\Channels;

use App\Models\Tag;
use App\Models\TagOnItem;

trait CheckIfChannelInInPromoTrait
{
    public function check_if_is_in_promo(object $channel): bool
    {
        // Promo tag is has name Kanál v PROMU

        $promoTag = Tag::whereName('Kanál v PROMU')->first();

        if (TagOnItem::whereType('channel')->where('item_id', $channel->id)->where('tag_id', $promoTag->id)->first()) {
            return true;
        }

        return false;
    }
}
