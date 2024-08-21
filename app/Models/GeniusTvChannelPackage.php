<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class GeniusTvChannelPackage extends Model
{
    protected $fillable = [
        'name',
    ];

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', '%'.$search.'%');
    }
}
