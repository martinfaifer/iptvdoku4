<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTVStaticTax extends Model
{
    protected $fillable = [
        'name',
        'price',
        'currency',
    ];

    public function currency_name(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }

    public function scopeSubscriptionTaxes(Builder $query, bool $isAkcionar): void
    {
        if ($isAkcionar == true) {
            $query
                ->whereIn('name', [
                    'osa',
                    'dilia',
                    'integram',
                    'oaza',
                    'OOA-S',
                    'NanguUser',
                    'akcionarHls',
                    'aplikacePocasi',
                    'aplikacePocasi',
                    'EPG',
                ]);
        } else {
            $query
                ->whereIn('name', [
                    'osa',
                    'dilia',
                    'integram',
                    'oaza',
                    'OOA-S',
                    'NanguUser',
                    'Genius',
                    'aplikacePocasi',
                    'aplikacePocasi',
                    'EPG',
                ]);
        }
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', '%' . $search . '%');
    }
}
