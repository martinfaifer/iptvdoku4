<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'type',
        'item_id',
        'message'
    ];
}
