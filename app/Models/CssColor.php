<?php

namespace App\Models;

use App\Observers\CssColorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(CssColorObserver::class)]
class CssColor extends Model
{
    protected $fillable = [
        'color', 'hex',
    ];
}
