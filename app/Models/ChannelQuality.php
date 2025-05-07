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

    public function scopeAvailableFormatsFor(Builder $query, string $format): void
    {
        $query->where('format', $format);
    }

    public function scopeSearch(Builder $query, string $search = ""): void
    {
        $query->where('name', 'like', $search . '%')->orWhere('format', 'like', $search . '%');
    }
}
