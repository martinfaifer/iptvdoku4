<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'type', // channel, device , card,
        'item_id',
        'full_name',
        'email',
        'phone',
    ];
}
