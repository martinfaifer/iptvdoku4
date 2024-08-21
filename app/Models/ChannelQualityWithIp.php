<?php

namespace App\Models;

use App\Observers\ChannelQualityWithIpObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ChannelQualityWithIpObserver::class)]
class ChannelQualityWithIp extends Model
{
    protected $fillable = [
        'h264_id',
        'h265_id',
        'channel_quality_id',
        'ip',
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

    public function scopeSearch(Builder $query, string $search = ''): void
    {
        $query->where('ip', 'like', '%' . $search . '%');
    }
}
