<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceTemplateGpu extends Model
{
    protected $fillable = [
        'name',
        'max_streams'
    ];

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', "like", "%" . $search . "%");
    }
}
