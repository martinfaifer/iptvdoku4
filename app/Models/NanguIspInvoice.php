<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class NanguIspInvoice extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'nangu_isp_id',
        'invoice',
        'path',
    ];

    public function scopeSearch(Builder $query, string $search)
    {
        $nanguIsp = NanguIsp::search($search)->first();
        if ($nanguIsp) {
            return $query->where('nangu_isp_id', 'like', '%'.$nanguIsp->id.'%');
        }
    }
}
