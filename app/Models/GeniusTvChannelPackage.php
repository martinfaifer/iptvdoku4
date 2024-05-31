<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;

class GeniusTvChannelPackage extends Model
{
    protected $fillable = [
        'name',
    ];

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('name', "like", "%" . $search . "%");
    }
}
