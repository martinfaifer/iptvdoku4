<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTVchannelsTax extends Model
{
    protected $fillable = [
        'channel_id',
        'price',
        'currency'
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function currency_name(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }

    public function scopeSearch(Builder $query, string $search = "")
    {
        $channel = Channel::search($search)->first();
        if ($channel) {
            return $query->where('price', "like", "%" . $search . "%")
                ->orWhere('channel_id', "like", "%" . $channel->id . "%");
        }
    }
}
