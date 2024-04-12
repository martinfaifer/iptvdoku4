<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTvChart extends Model
{
    protected $fillable = [
        'item',
        'value',
        'nangu_isp_id'
    ];

    public function nanguIsp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id', 'id');
    }

    public function scopeWithoutNanguIsp(Builder $query)
    {
        return $query->where('nangu_isp_id', null);
    }

    public function scopeIsChannel(Builder $query, string|int $channelId)
    {
        return $query->where('item', "channel:$channelId");
    }

    public function scopeLastMonthAndNew(Builder $query)
    {
        return $query->where('created_at', ">=", now()->subMonth());
    }

    public function scopeForNanguIsp(Builder $query, string|int $nanguIspId)
    {
        return $query->where('nangu_isp_id', $nanguIspId);
    }
}
