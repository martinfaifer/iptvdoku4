<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class IptvDohledUrl extends Model
{
    protected $fillable = [
        'iptv_dohled_id',
        'stream_url',
        'can_notify',
    ];

    public $casts = [
        'can_notify' => 'boolean',
    ];

    public function scopeStreamUrl(Builder $query, string $stream_url): void
    {
        $query->where('stream_url', $stream_url);
    }
}
