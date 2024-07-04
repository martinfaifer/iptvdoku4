<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\ChannelSourceObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Livewire\Iptv\Channels\Multicast\MulticastChannel;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(ChannelSourceObserver::class)]
class ChannelSource extends Model
{
    protected $fillable = [
        'name',
    ];

    public function multicasts(): HasMany
    {
        return $this->hasMany(ChannelMulticast::class, 'channel_source_id');
    }

    public function scopeSearch(Builder $query, string $search = "")
    {
        return $query->where('name', "like", "%" . $search. "%");
    }
}
