<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTVChannelsOffersTax extends Model
{
    protected $fillable = [
        'offer',
        'channels_id',
        'price',
        'currency',
    ];

    public function currency_name(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }

    public function scopeSearch(Builder $query, string $search = '')
    {
        $channel = Channel::search($search)->first();
        if ($channel) {
            return $query->where('price', 'like', '%'.$search.'%')
                ->orWhere('channels_id', 'like', '%'.$channel->id.'%');
        }
    }
}
