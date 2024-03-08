<?php

namespace App\Models;

use App\Livewire\Iptv\Channels\Multicast\MulticastChannel;
use Illuminate\Database\Eloquent\Model;

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
