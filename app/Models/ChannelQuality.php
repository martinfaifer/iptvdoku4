<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChannelQuality extends Model
{
    protected $fillable = [
        'name',
        'bitrate',
        'min_bitrate',
        'port',
        'format',
    ];

    public function ips(): HasMany
    {
        return $this->hasMany(ChannelQualityWithIp::class, 'channel_quality_id', 'id');
    }

    public function scopeAvailableFormatsFor(Builder $query, string $format)
    {
        return $query->where('format', $format);
    }
}
