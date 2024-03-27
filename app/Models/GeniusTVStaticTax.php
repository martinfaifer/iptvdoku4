<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTVStaticTax extends Model
{
    protected $fillable = [
        'name',
        'price',
        'currency'
    ];


    public function currency_name(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('name', "like", "%" . $search . "%");
    }
}
