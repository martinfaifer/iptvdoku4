<?php

namespace App\Models;

use App\Livewire\Iptv\Channels\Multicast\MulticastChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChannelMulticast extends Model
{
    protected $fillable = [
        'channel_id',
        'stb_ip',
        'source_ip',
        'channel_source_id',
        'is_backup',
        'devices_id',
        'status'
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function multicasts(): HasMany
    {
        return $this->hasMany(ChannelMulticast::class, 'channel_id', 'id');
    }

    public function channel_source(): HasOne
    {
        return $this->hasOne(ChannelSource::class, 'id', 'channel_source_id');
    }
}
