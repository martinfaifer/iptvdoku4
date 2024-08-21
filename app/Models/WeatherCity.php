<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class WeatherCity extends Model
{
    protected $fillable = [
        'city',
        'state',
    ];

    public function scopeSearch(Builder $query, string $search = ''): void
    {
        $query->where('city', 'like', '%'.$search.'%');
    }
}
