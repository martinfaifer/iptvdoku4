<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;

class IptvDohledUrl extends Model
{
    protected $fillable = [
        'iptv_dohled_id',
        'stream_url'
    ];

    public function scopeStreamUrl(Builder $query, string $stream_url)
    {
        return $query->where('stream_url', $stream_url);
    }
}
