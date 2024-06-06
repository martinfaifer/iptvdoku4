<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Alert extends Model
{
    use Prunable;

    protected $fillable = [
        'type',
        'item_id',
        'message',
    ];

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->week());
    }
}
