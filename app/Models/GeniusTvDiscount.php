<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class GeniusTvDiscount extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'nangu_isp_id',
        'discount',
    ];

    public function scopeSearch(Builder $query, string $search = ""): void
    {
        if (!blank($search)) {
            $nanguIsp = NanguIsp::search($search)->first();
            if ($nanguIsp) {
                $query->where('nangu_isp_id', $nanguIsp->id);
            }
        }
    }
}
