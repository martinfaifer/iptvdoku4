<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GeniusTvChart extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'item',
        'value',
        'nangu_isp_id',
    ];

    public function scopeWithoutNanguIsp(Builder $query): void
    {
        $query->where('nangu_isp_id', null);
    }

    public function scopeIsChannel(Builder $query, string|int $channelId): void
    {
        $query->where('item', "channel:$channelId");
    }

    public function scopeLastMonthAndNew(Builder $query): void
    {
        $query->where('created_at', '>=', now()->subMonth());
    }

    public function scopeForNanguIsp(Builder $query, string|int $nanguIspId): void
    {
        $query->where('nangu_isp_id', $nanguIspId);
    }
}
