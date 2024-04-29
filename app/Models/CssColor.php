<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CssColor extends Model
{
    protected $fillable = [
        'color', 'hex',
    ];
}
