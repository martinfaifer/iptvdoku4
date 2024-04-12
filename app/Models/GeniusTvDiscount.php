<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTvDiscount extends Model
{
    protected $fillable = [
        'nangu_isp_id',
        'discount',
    ];

    public function nanguIsp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $nanguIsp = NanguIsp::search($search)->first();
        if ($nanguIsp) {
            return $query->where('nangu_isp_id', "like", "%" . $nanguIsp->id);
        }
    }
}
