<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;

class WeatherCity extends Model
{
    protected $fillable = [
        'city', 'state'
    ];

    public function scopeSearch(Builder $query, string $search = "")
    {
        return $query->where('city', "like", "%" . $search . "%");
    }
}
