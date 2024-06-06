<?php

namespace App\Models;

use App\Observers\H264Observer;
use App\Traits\Models\ChannelTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(H264Observer::class)]
class H264 extends Model
{
    use ChannelTrait;

    protected $fillable = [
        'channel_id',
        'devices_id',
        'status',
    ];

    public function ips(): HasMany
    {
        return $this->hasMany(ChannelQualityWithIp::class, 'h264_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'h264_id');
    }
}
