<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestartChannel extends Model
{
    protected $fillable = [
        'channel_id',
        'ip_id',
        'device_id'
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function stream_ip():BelongsTo
    {
        return $this->belongsTo(ChannelQualityWithIp::class, 'ip_id', 'id');
    }
}
