<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\ChannelQualityWithIpObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ChannelQualityWithIpObserver::class)]
class ChannelQualityWithIp extends Model
{
    protected $fillable = [
        'h264_id', 'h265_id', 'channel_quality_id', 'ip'
    ];

    public function h264(): BelongsTo
    {
        return $this->belongsTo(H264::class, 'h264_id');
    }

    public function h265(): BelongsTo
    {
        return $this->belongsTo(H265::class, 'h265_id');
    }

    public function channelQuality(): BelongsTo
    {
        return $this->belongsTo(ChannelQuality::class, 'channel_quality_id');
    }
}
