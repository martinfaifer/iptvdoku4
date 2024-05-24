<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTvChart extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'item',
        'value',
        'nangu_isp_id',
    ];


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
        return $query->where('created_at', '>=', now()->subMonth());
    }

    public function scopeForNanguIsp(Builder $query, string|int $nanguIspId)
    {
        return $query->where('nangu_isp_id', $nanguIspId);
    }
}
