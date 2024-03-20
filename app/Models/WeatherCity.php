<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCity extends Model
{
    protected $fillable = [
        'city', 'state'
    ];
}
