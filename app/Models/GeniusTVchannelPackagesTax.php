<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTVchannelPackagesTax extends Model
{
    protected $fillable = [
        'channels_id', 'price', 'currency', 'exception', 'must_contains_all',
    ];

    public function currency_name(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }

    public function scopeSearch(Builder $query, string $search = '')
    {
        if ($channel = Channel::searchend($search)->first()) {
            return $query->where('price', 'like', '%'.$search.'%')
                ->orWhere('channels_id', 'like', '%'.$channel->id.'%');
        }
    }
}
