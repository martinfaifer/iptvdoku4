<?php

namespace App\Models;

use App\Livewire\Iptv\Channels\Multicast\MulticastChannel;
use App\Observers\ChannelSourceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ChannelSourceObserver::class)]
class ChannelSource extends Model
{
    protected $fillable = [
        'name',
    ];

    public function multicasts()
    {
        return $this->hasMany(MulticastChannel::class, 'channel_source_id');
    }
}
